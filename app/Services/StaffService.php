<?php

namespace App\Services;

use App\Models\Staff;
use App\Repositories\StaffRepository;
use App\Repositories\StudentRepository;
use App\Untils\DataBroTable;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Staff\Object\StaffListObject;
use App\ViewModels\Staff\Object\StaffStoreObject;
use App\ViewModels\Staff\StaffListViewModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffService implements \App\Contract\CrudServicesInterface
{
    public function __construct(
        private readonly StaffRepository   $staffRepository,
        private readonly StudentRepository $studentRepository,
    )
    {
    }

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã nhân viên',
            'name' => 'Tên nhân viên',
            'job' => 'Chức vụ',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
        ];
    }

    public function setupFilterOperation($old = [])
    {
        return [
            [
                'name' => 'name',
                'label' => 'Tên nhân viên',
                'type' => 'text',
                'value' => $old['name'] ?? null,
            ],
            [
                'name' => 'code',
                'label' => 'Mã nhân viên',
                'type' => 'text',
                'value' => $old['code'] ?? null,
            ],
            [
                'name' => 'email',
                'label' => 'Email nhân viên',
                'type' => 'text',
                'value' => $old['email'] ?? null,
            ],
            [
                'name' => 'phone',
                'label' => 'Số điện thoại',
                'type' => 'text',
                'value' => $old['phone'] ?? null,
            ],
        ];
    }

    public function setupCreateOperation($old = null): CrudEntry
    {
//        dd( $old?->Student()->get()->pluck("id")->toArray());
        $entry = new CrudEntry("staffs", $old->id ?? null, "Nhân viên");
        $entry->addField([
            'name' => 'code',
            'label' => 'Mã nhân viên',
            'type' => 'text',
            'class' => 'col-md-2',
            'value' => $old['code'] ?? null,
        ]);
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên nhân viên',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['name'] ?? null,
        ]);
        $entry->addField([
            'name' => 'job',
            'label' => 'Chức vụ',
            'type' => 'text',
            'class' => 'col-md-4',
            'value' => $old['job'] ?? null,
        ]);
        $entry->addField([
            'name' => 'email',
            'label' => 'Email nhân viên',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['email'] ?? null,
        ]);
        $entry->addField([
            'name' => 'phone',
            'label' => 'Số điện thoại nhân viên',
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
            'name' => 'address',
            'label' => 'Địa chỉ',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['address'] ?? null,
        ]);
        $entry->addField([
            'name' => "extra",
            'label' => 'Thông tin thêm',
            'type' => 'repeatable',
            'value' => $old["extra"] ?? null,
            'new_label' => 'Thêm thông tin',
            'sub_fields' => [
                [
                    'name' => 'name',
                    'class' => 'col-md-5',
                    'type' => 'text',
                    'label' => 'Tên thông tin',
                ],
                [
                    'name' => 'info',
                    'type' => 'text',
                    'label' => 'Thông tin',
                    'class' => 'col-md-5',
                ]
            ]

        ]);
        $entry->addField([
            'name' => 'password',
            'label' => 'Mật khẩu',
            'type' => 'password',

        ]);
        return $entry;
    }

    public function setupEditOperation($id)
    {
        $old = $this->staffRepository->show($id);
        if (!isset($old->id)) {
            return to_route("staffs.index")->with("success", "Không tìm thấy");
        }
        return $this->setupCreateOperation($old);
    }

    public function validate($attributes, $id = null)
    {
        return Validator::make($attributes,
            [
                'name' => 'required',
                'code' => 'required',
                'job' => 'required',
                'email' => 'email|required|unique:users,email,' . $id ?? null
            ],
            [
                'name.required' => 'Tên không được để trống',
                'code.required' => 'Code không được để trống',
                'job.required' => 'Không để để trống',
                'email.email' => 'Định dạng email không đúng',
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email đã có trong hệ thống'
            ]
        );
    }

    public function list($attributes): JsonResponse
    {
        $count = $this->staffRepository->count($attributes);
        $staffCollection = $this->staffRepository->index($attributes);
        $staffListViewModel = new StaffListViewModel(
            staffs: $staffCollection->map(
                fn(Staff $staff) => (new StaffListObject(
                    id: $staff['id'],
                    code: $staff['code'],
                    name: $staff['name'],
                    job: $staff['job'],
                    phone: $staff['phone'] ?? "-",
                    email: $staff['email']
                ))->toArray()
            )->toArray()
        );
        return DataBroTable::collect($staffListViewModel->getStaffs(), $count, $attributes);
    }

    public function store($attributes)
    {
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        $staff = $this->staffRepository->create((new StaffStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            job: $attributes['job'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            extra: $attributes['extra'] ?? [],
            password: Hash::make($attributes['password'])
        ))->toArray());

    }

    public function update($attributes, $id): RedirectResponse
    {
//        dd($attributes);
        $old = $this->staffRepository->show($id);
        if (!isset($old->id)) {
            return to_route("staffs.index")->with("success", "Không tìm thấy");
        }
        $validate = $this->validate($attributes, $id);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        $this->staffRepository->update((new StaffStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            job: $attributes['job'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            extra: $attributes['extra'] ?? [],
            password: $attributes['password'] ? Hash::make($attributes['password']) : $old->password,
        ))->toArray(), $old->id);
        return to_route("staffs.index")->with("success", "Cập nhật thành công");
    }

    public function delete($id)
    {
        if ($this->staffRepository->delete($id))
            return to_route("staffs.index")->with("success", "Xóa thành công");
        else
            return to_route("staffs.index")->with("success", "Xóa thành công");
    }
}
