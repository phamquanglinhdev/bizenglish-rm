<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Client\ClientListViewModel;
use App\ViewModels\Client\Object\ClientListObject;
use App\ViewModels\Client\Object\ClientStoreObject;
use App\ViewModels\Entry\CrudEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientService implements \App\Contract\CrudServicesInterface
{
    public function __construct(
        private readonly ClientRepository $clientRepository,
    )
    {
    }

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã đối tác',
            'name' => 'Tên đối tác',
            'email' => 'Email của đối tác',
            'phone' => 'Số điện thoại',
            'client_status' => 'Tình trạng hợp tác',
        ];
    }

    public function list($attributes): JsonResponse
    {
        $count = $this->clientRepository->count($attributes);
        $clientCollection = $this->clientRepository->index($attributes);
        $clientListViewModel = new ClientListViewModel(
            clients: $clientCollection->map(
                fn(Client $client) => (new ClientListObject(
                    id: $client['id'],
                    code: $client['code'],
                    name: $client['name'],
                    email: $client['email'],
                    phone: $client['phone'] ?? "-",
                    client_status: $client->getStatus()
                ))->toArray()
            )->toArray()
        );
        return DataBroTable::collect($clientListViewModel->getClients(), $count, $attributes);
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

    public function setupCreateOperation(Client $old = null): CrudEntry
    {
        $entry = new CrudEntry("clients", $old->id ?? null, "Đối tác");
        $entry->addField([
            'name' => 'code',
            'label' => 'Mã đối tác',
            'value' => $old['code'] ?? null,
            'type' => 'text',
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên đối tác',
            'value' => $old['name'] ?? null,
            'type' => 'text',
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'name' => 'email',
            'label' => 'Email đối tác',
            'value' => $old['email'] ?? null,
            'type' => 'text',
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'value' => $old['phone'] ?? null,
            'type' => 'text',
            'class' => 'col-md-6'
        ]);
        $entry->addField([
            'name' => 'facebook',
            'label' => 'Facebook',
            'value' => $old['facebook'] ?? null,
            'type' => 'text',
            'class' => 'col-md-6'
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
            $link = $file['link'];
            $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/teachers") ?? null;
        }
        /**
         * @var Client $clientModel
         */
        $clientModel = $this->clientRepository->create((new ClientStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            client_status: $attributes['client_status'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray());
        return to_route("clients.index")->with("success", "Thêm đối tác thành công");
    }

    public function setupEditOperation($id): RedirectResponse|CrudEntry
    {
        /**
         * @var Client $oldClient
         */
        $oldClient = $this->clientRepository->show($id);
        if (!isset($oldClient->id)) {
            return to_route("clients.index")->with("success", "Không tìm thấy");
        }
        return $this->setupCreateOperation($oldClient);
    }

    public function update($attributes, $id)
    {
        /**
         * @var Client $oldClient
         */
        $oldClient = $this->clientRepository->show($id);
        if (!isset($oldClient->id)) {
            return to_route("clients.index")->with("success", "Không tìm thấy");
        }
        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        } else {
            $attributes["password"] = $oldClient->password;
        }
        $validate = $this->validate($attributes, $oldClient->id);
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
        $this->clientRepository->update((new ClientStoreObject(
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
        return to_route("clients.index")->with("success", "Cập nhật thành công");
    }

    public function delete($id): RedirectResponse
    {
        if ($this->clientRepository->delete($id)) {
            return to_route("clients.index")->with("success", "Xóa thành công");
        } else {
            return to_route("clients.index")->with("success", "Xóa thất bại");
        }
    }
}
