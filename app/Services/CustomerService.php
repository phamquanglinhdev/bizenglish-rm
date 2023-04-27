<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Customer;
use App\Models\Teacher;
use App\Repositories\CustomerRepository;
use App\Repositories\StaffRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Customer\CustomerListViewModel;
use App\ViewModels\Customer\Object\CustomerListObject;
use App\ViewModels\Customer\Object\CustomerStoreObject;
use App\ViewModels\Entry\CrudEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerService implements CrudServicesInterface
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly StaffRepository    $staffRepository,
    )
    {
    }

    public function setupListOperation(): array
    {
        return [
            'code' => 'Mã khách hàng',
            'name' => 'Tên khách hàng',
            'staff' => 'Nhân viên quản lý',
            'email' => 'Email của khách hàng',
            'phone' => 'Số điện thoại',
            'student_status' => 'Phân lại khách hàng',
        ];

    }

    public function list($attributes = null): JsonResponse
    {
        $count = $this->customerRepository->count($attributes);
        $customerCollection = $this->customerRepository->index($attributes);
        $customerListViewModel = new CustomerListViewModel(
            customers: $customerCollection->map(
                fn(Customer $customer) => (new CustomerListObject(
                    id: $customer['id'],
                    code: $customer['code'],
                    name: $customer['name'],
                    staff: json_encode($customer->Staff()->first()),
                    email: $customer['email'],
                    phone: $customer['phone'],
                    student_status: $customer->getStatus()
                ))->toArray()
            )->toArray()
        );
        return DataBroTable::collect($customerListViewModel->getCustomers(), $count, $attributes);
    }

    public function setupFilterOperation($attributes = null): array
    {
        return [];
    }

    public function validate($attributes, $id = null): \Illuminate\Validation\Validator
    {
        return Validator::make($attributes,
            [
                'name' => 'required',
                'code' => 'required',
                'email' => 'email|required|unique:users,email,' . $id ?? null,
                'staff_id' => 'numeric|required',
                'student_status' => 'numeric|required',
                'password' => 'required'
            ],
            [
                '*.required' => 'Không được để trống',
                'email.email' => 'Định dạng email không đúng',
                'email.unique' => 'Email đã có trong hệ thống',
                '*.numeric' => 'Không đúng định dạng'
            ]
        );
    }

    public function setupCreateOperation(Customer $old = null): CrudEntry
    {
        $entry = new CrudEntry("customers", $old->id ?? null, "Khách hàng");
        $entry->addField([
            'name' => 'code',
            'label' => 'Mã khách hàng',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['code'] ?? null
        ]);
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên khách hàng',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['name'] ?? null
        ]);
        $entry->addField([
            'name' => 'email',
            'label' => 'Email khách hàng',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['email'] ?? null
        ]);
        $entry->addField([
            'name' => 'phone',
            'label' => 'Số điện thoại',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['phone'] ?? null
        ]);
        $entry->addField([
            'name' => 'facebook',
            'label' => 'Facebook',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['facebook'] ?? null
        ]);
        $entry->addField([
            'name' => 'address',
            'label' => 'Địa chỉ',
            'class' => 'col-md-6',
            'type' => 'text',
            'value' => $old['address'] ?? null
        ]);
        $entry->addField([
            'name' => 'staff_id',
            'label' => 'Nhân viên quản lý',
            'class' => 'col-md-6',
            'type' => 'select2',
            'options' => $this->staffRepository->getForSelect(),
            'value' => $old['staff_id'] ?? null
        ]);
        $entry->addField([
            'name' => 'student_status',
            'label' => 'Phân loại khách hàng',
            'class' => 'col-md-6',
            'type' => 'select2',
            'options' => [
                0 => 'Tiềm năng',
                1 => 'Không tiềm năng',
                2 => 'Chưa học thử'
            ],
            'value' => $old['staff_id'] ?? null
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
            $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/customers") ?? null;
        }
        /**
         * @var Customer $customerModel
         */
        $customerModel = $this->customerRepository->create((new CustomerStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            address: $attributes['address'],
            staff_id: $attributes['staff_id'],
            student_status: $attributes['student_status'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray());
        return to_route("customers.index")->with("success", "Thêm thành công");
    }

    public function setupEditOperation($id): RedirectResponse|CrudEntry
    {
        /**
         * @var Customer $oldCustomer
         */
        $oldCustomer = $this->customerRepository->show($id);
        if (!isset($oldCustomer->id)) {
            return to_route("customers.index")->with("success", "Không tìm thấy");
        }
        return $this->setupCreateOperation($oldCustomer);
    }

    public function update($attributes, $id): RedirectResponse
    {
        /**
         * @var Customer $oldCustomer
         */
        $oldCustomer = $this->customerRepository->show($id);
        if (!isset($oldCustomer->id)) {
            return to_route("customers.index")->with("success", "Không tìm thấy");
        }
        if ($attributes["password"] != null) {
            $attributes["password"] = Hash::make($attributes['password']);
        } else {
            $attributes["password"] = $oldCustomer->password;
        }
        $validate = $this->validate($attributes, $oldCustomer->id);
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
                $attributes['files'][$key]['link'] = EzUpload::uploadToStorage($link, $link->getClientOriginalName(), "/customers") ?? null;
            }
            unset($attributes['files'][$key]['link-old']);
        }
        $this->customerRepository->update((new CustomerStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            phone: $attributes['phone'],
            address: $attributes['address'],
            staff_id: $attributes['staff_id'],
            student_status: $attributes['student_status'],
            extra: $attributes['extra'],
            files: $attributes['files'],
            password: $attributes['password']
        ))->toArray(), $id);
        return to_route("customers.index")->with("success", "Cập nhật thành công");
    }
}
