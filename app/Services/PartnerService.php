<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Client\Object\ClientStoreObject;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Partner\Object\PartnerListObject;
use App\ViewModels\Partner\Object\PartnerStoreObject;
use App\ViewModels\Partner\PartnerListViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PartnerService implements CrudServicesInterface
{
    public function __construct(
        private readonly PartnerRepository $partnerRepository
    )
    {
    }

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã đối tác',
            'name' => 'Tên đối tác',
            'email' => 'Email đối tác',
            'phone' => 'Số điện thoại',
            'client_status' => 'Tình trạng hợp tác',
        ];
    }

    public function list($attributes): JsonResponse
    {
        $count = $this->partnerRepository->count($attributes);
        $partnerCollection = $this->partnerRepository->index($attributes);
        $partnerListViewModel = new PartnerListViewModel($partnerCollection->map(
            fn(Partner $partner) => (new PartnerListObject(
                id: $partner['id'],
                code: $partner['code'],
                name: $partner['name'],
                email: $partner['email'],
                phone: $partner['phone'] ?? "-",
                client_status: $partner->getStatus()
            ))->toArray()
        )->toArray());
        return DataBroTable::collect($partnerListViewModel->getPartners(), $count, $attributes);
    }

    public function setupFilterOperation(): array
    {
        return [];
    }

    public function validate($attributes, $id = null): \Illuminate\Validation\Validator
    {
        return Validator::make($attributes,
            [
                'name' => 'required',
                'code' => 'required',
                'email' => 'email|required|unique:users,email,' . $id,
                'phone' => 'numeric|required',
                'client_status' => 'required|numeric',
                'password' => 'required'
            ]
            ,
            [
                '*.required' => 'Không được để trống',
                '*.numeric' => 'Không đúng định dạng',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
            ]
        );
    }

    public function setupCreateOperation(Partner $old = null): CrudEntry
    {
        $entry = new CrudEntry("partners", $old->id ?? null, "Partnership");
        $entry->addField([
            'name' => 'code',
            'label' => 'Mã partnership',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['code'] ?? null,
        ]);
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên partnership',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['name'] ?? null,
        ]);
        $entry->addField([
            'name' => 'email',
            'label' => 'Email partnership',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['email'] ?? null,
        ]);
        $entry->addField([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['phone'] ?? null,
        ]);
        $entry->addField([
            'name' => 'facebook',
            'label' => 'Link facebook',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['facebook'] ?? null,
        ]);
        $entry->addField([
            'name' => 'client_status',
            'label' => 'Tình trạng hợp tác',
            'value' => $old['client_status'] ?? null,
            'type' => 'select2',
            'class' => 'col-md-6',
            'options' => [
                0 => 'Đang hợp tác',
                1 => 'Hợp tác ít',
                2 => 'Ngừng hợp tác',
            ]
        ]);
        $entry->addField([
            'name' => 'extra',
            'label' => 'Thông tin thêm',
            'type' => 'repeatable',
            'new_label' => 'Thêm thông tin',
            'value' => $old['extra'] ?? null,
            'sub_fields' => [
                [
                    'name' => 'name',
                    'label' => 'Tên thông tin',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],
                [
                    'name' => 'info',
                    'label' => 'Giá trị',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],

            ]
        ]);
        $entry->addField([
            'name' => 'files',
            'label' => 'File đính kèm',
            'type' => 'repeatable',
            'new_label' => 'Thêm file đính kèm',
            'value' => $old['files'] ?? null,
            'sub_fields' => [
                [
                    'name' => 'name',
                    'label' => 'Tiêu đề',
                    'type' => 'text',
                    'class' => 'col-md-5'
                ],
                [
                    'name' => 'link',
                    'label' => 'File đính kèm',
                    'type' => 'upload',
                    'class' => 'col-md-5'
                ],

            ]
        ]);
        $entry->addField([
            'name' => 'password',
            'label' => 'Mật khẩu',
            'type' => 'password',
        ]);
        return $entry;
    }

    public function create($attributes): RedirectResponse
    {

        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        }
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        foreach ($attributes['files'] as $key => $file) {
            /**
             * @var UploadedFile $link
             */
            $link = $file['link'] ?? null;
            if ($link != null) {
                $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/teachers") ?? null;
            }
        }
        /**
         * @var Partner $partnerModel
         */
        $dataCreate = (new PartnerStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            client_status: $attributes['client_status'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray();
        $partnerModel = $this->partnerRepository->create($dataCreate);
        return to_route("partners.index")->with("success", "Thêm  thành công");
    }

    public function setupEditOperation($id): RedirectResponse|CrudEntry
    {
        /**
         * @var Partner $partnerClient
         */
        $partnerClient = $this->partnerRepository->show($id);
        if (!isset($partnerClient->id)) {
            return to_route("partners.index")->with("success", "Không tìm thấy");
        }
        return $this->setupCreateOperation($partnerClient);
    }
    public function update($attributes,$id): RedirectResponse
    {
        /**
        * @var Partner $oldPartner
        */
        $oldPartner = $this->partnerRepository->show($id);
        if (!isset($oldPartner->id)) {
            return to_route("partners.index")->with("success", "Không tìm thấy");
        }
        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        } else {
            $attributes["password"] = $oldPartner->password;
        }
        $validate = $this->validate($attributes, $oldPartner->id);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        foreach ($attributes['files'] as $key => $file) {
            /**
             * @var UploadedFile $link
             */
            if (!isset($attributes['files'][$key]['link'])) {
                $attributes['files'][$key]['link'] = $file['link-old'] ?? null;

            } else {
                $link = $file['link'];
                $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/clients") ?? null;
            }
            unset($attributes['files'][$key]['link-old']);
        }
        $this->partnerRepository->update((new PartnerStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            client_status: $attributes['client_status'],
            extra: $attributes['extra']??[],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray(), $id);
        return to_route("partners.index")->with("success", "Cập nhật thành công");
    }

}
