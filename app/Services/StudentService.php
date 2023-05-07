<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Log;
use App\Models\Student;
use App\Repositories\StaffRepository;
use App\Repositories\StudentRepository;
use App\Untils\DataBroTable;
use App\Untils\EzUpload;
use App\ViewModels\Entry\CrudEntry;
use App\ViewModels\Staff\Object\StaffListObject;
use App\ViewModels\Staff\StaffListViewModel;
use App\ViewModels\Student\Object\StudentListObject;
use App\ViewModels\Student\Object\StudentLogsObject;
use App\ViewModels\Student\Object\StudentShowObject;
use App\ViewModels\Student\Object\StudentStoreObject;
use App\ViewModels\Student\StudentListViewModel;
use App\ViewModels\Student\StudentShowViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Ramsey\Collection\Collection;

class StudentService implements CrudServicesInterface
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
        private readonly StaffRepository   $staffRepository,
    )
    {
    }

    /**
     * @return mixed
     */
    public function setupListOperation(): array
    {
        return [

            'code' => 'Mã học sinh',
            'name' => 'Tên học sinh',
            'staff' => 'Nhân viên quản lý',
            'supporter' => 'Nhân viên hỗ trợ',
            'student_parent' => 'Người giám hộ',
            'phone' => 'Số điện thoại',
            'grades' => 'Lớp',
            'email' => 'Email',
            'status' => 'Tình trạng học sinh',
        ];
    }

    /**
     * @return array
     */
    public function setupFilterOperation($old = []): array
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function setupCreateOperation($old = null): CrudEntry
    {
        // TODO: Implement setupCreateOperation() method.
        $entry = new CrudEntry("students", $old->id ?? null, "Học sinh");
        $entry->addField([
            'name' => 'code',
            'label' => 'Mã học sinh',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['code'] ?? null,
        ]);
        $entry->addField([
            'name' => 'name',
            'label' => 'Tên học sinh',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['name'] ?? null,
        ]);
        $entry->addField([
            'name' => 'email',
            'label' => 'Email học sinh',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['email'] ?? null,
        ]);
        $entry->addField([
            'name' => 'student_parent',
            'label' => 'Người giám hộ',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['student_parent'] ?? null,
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
            'label' => 'Facebook',
            'type' => 'text',
            'class' => 'col-md-6',
            'value' => $old['facebook'] ?? null,
        ]);
        $entry->addField([
            'name' => 'address',
            'label' => 'Địa chỉ',
            'type' => 'text',
            'value' => $old['address'] ?? null,
        ]);
        $entry->addField([
            'name' => 'student_status',
            'label' => 'Tình trạng học sinh',
            'type' => 'select2',
            'class' => 'col-md-6',
            'value' => $old['student_status'] ?? null,
            'options' => [
                0 => 'Đang học',
                1 => 'Đã ngừng học',
                2 => 'Đang bảo lưu'
            ]
        ]);
        $entry->addField([
            'name' => 'staff_id',
            'label' => 'Nhân viên quản lý',
            'type' => 'select2',
            'class' => 'col-md-6',
            'value' => $old['student_status'] ?? null,
            'options' => $this->staffRepository->getForSelect(),
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

    public function setupEditOperation($id)
    {
        $old = $this->studentRepository->show($id);
        if (!isset($old->id)) {
            return to_route("students.index")->with("success", "Không tìm thấy");
        }
        return $this->setupCreateOperation($old);
    }

    public function list($attribute): JsonResponse
    {
        $count = $this->studentRepository->count($attribute);
        $studentCollection = $this->studentRepository->index($attribute);
        $studentListViewModel = new StudentListViewModel(
            students: $studentCollection->map(
                fn(Student $student) => (new StudentListObject(
                    id: $student['id'],
                    status: $student->getStatus(),
                    code: $student['code'],
                    name: $student['name'],
                    staff: $student->Staff()->first(),
                    supporter: $student->Supporter(),
                    student_parent: $student['student_parent'],
                    grades: $student->Grades()->get()->pluck("name", "id")->toArray(),
                    email: $student['email'],
                    phone: $student['phone']
                ))->toArray()
            )->toArray()
        );
        return DataBroTable::collect($studentListViewModel->getStudents(), $count, $attribute);
    }

    public function validate($attributes, $id = null): \Illuminate\Validation\Validator
    {
        return Validator::make($attributes,
            [
                'name' => 'required',
                'code' => 'required',
                'email' => 'email|required|unique:users,email,' . $id ?? null,
                'phone' => 'required',
                'student_status' => 'required|numeric',
                'staff_id' => 'required|numeric',
                'password' => 'required'
            ],
            [
                '*.required' => 'Không được để trống',
                '*.numeric' => 'Dữ liệu không hợp lệ',
                'email.email' => 'Sai định dạng email',
                'email.unique' => 'Email đã tồn tại trong hệ thống'
            ]
        );
    }

    public function store($attributes, array $fileBag): RedirectResponse
    {
        $validate = $this->validate($attributes);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        if (isset($attributes['files'])) {
            $attributes = $this->handleFilesUploads($attributes, $fileBag);
        }
        $attributes['password'] = Hash::make($attributes['password']);
        if (isset($fileBag['files'])) {
            foreach ($fileBag['files'] as $key => $item) {
                if (!$attributes['files'][$key]['name']) {
                    $attributes['files'][$key]['name'] = $item['link']->getClientOriginalName();
                }
                $attributes['files'][$key]['link'] = $this->uploadFile($item['link']);
            }
        }
        $this->studentRepository->create((new StudentStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            student_parent: $attributes['student_parent'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            student_status: $attributes['student_status'],
            staff_id: $attributes['staff_id'],
            password: $attributes['password'],
            extra: $attributes['extra'] ?? null,
            files: $attributes['files'] ?? null,
        ))->toArray());
        return to_route("students.index")->with("success", "Thêm thành công");
    }

    public function uploadFile(UploadedFile $uploadedFile): string
    {
        return EzUpload::uploadToStorage($uploadedFile, $uploadedFile->getClientOriginalName(), "/students");
    }

    public function handleFilesUploads($attributes, $fileBag)
    {
        foreach ($attributes['files'] as $row => $fileRepeatable) {
            if (isset($fileBag['files'][$row])) {
                if (!$fileRepeatable['name']) {
                    $attributes['files'][$row]['name'] = Str::limit($fileBag['files'][$row]['link']->getClientOriginalName(), 20);
                }
                $attributes['files'][$row]['link'] = $this->uploadFile($fileBag['files'][$row]['link']);
            } elseif (isset($attributes['files'][$row]['link-old'])) {
                if (!$fileRepeatable['name']) {
                    $attributes['files'][$row]['name'] = Str::limit(str_replace("/uploads/students/", "", $fileRepeatable['old-link']), 20);
                }
                $attributes['files'][$row]['link'] = $attributes['files'][$row]['link-old'];
            } else {
                unset($attributes['files'][$row]);
            }
            unset($attributes['files'][$row]['link-old']);
        }
        return $attributes;
    }

    public function update($attributes, array $fileBag, $id): RedirectResponse
    {
        if (isset($attributes['files'])) {
            $attributes = $this->handleFilesUploads($attributes, $fileBag);
        }
        $old = $this->studentRepository->show($id);
        if (!isset($old->id)) {
            return to_route("students.index")->with("success", "Không tìm thấy");
        }
        if (!$attributes['password'] || $attributes['password'] == "") {
            $attributes['password'] = $old->password ?? null;
        } else {
            $attributes['password'] = Hash::make($attributes['password']);
        }
        $validate = $this->validate($attributes, $id);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }


        $this->studentRepository->update((new StudentStoreObject(
            code: $attributes['code'],
            name: $attributes['name'],
            email: $attributes['email'],
            student_parent: $attributes['student_parent'],
            phone: $attributes['phone'],
            facebook: $attributes['facebook'],
            address: $attributes['address'],
            student_status: $attributes['student_status'],
            staff_id: $attributes['staff_id'],
            password: $attributes['password'],
            extra: $attributes['extra'] ?? null,
            files: $attributes['files'] ?? null
        ))->toArray(), $id);
        return to_route("students.index")->with("success", "Cập nhật thành công");
    }

    public function delete($id): RedirectResponse
    {
        if ($this->studentRepository->delete($id))
            return to_route("students.index")->with("success", "Xóa thành công");
        else
            return to_route("students.index")->with("success", "Xóa thất bại");
    }

    public function showStudentProfile($id): StudentShowViewModel
    {
        /**
         * @var Student $student
         * @var Collection $logs
         */
        $student = $this->studentRepository->show($id);
        $logs = \Illuminate\Support\Collection::make($student->getLog());
        return new StudentShowViewModel(
            student: new StudentShowObject(
                id: $student["id"],
                name: $student["name"],
                code: $student["code"],
                phone: $student["phone"] ?? "-",
                parent: $student["student_parent"] ?? "Không",
                avatar: $student["avatar"] ?? "https://e2.yotools.net/images/user_image/2023/05/6457555910168.jpg",
                facebook: $student["facebook"],
                address: $student["address"],
                email: $student["email"],
                logCount: $student->getLogCount(),
                remaining: $student->getRemaining(),
                minutes: $student->getLogCountMinutes(),
                status: $student->getStatus(),
            ), studentLogs: $logs->map(
            fn(Log $log) => new StudentLogsObject(
                title: $log["lesson"],
                id: $log["id"],
                date: $log["date"],
                teacher: $log->Teacher()->first(),
                attachments: json_decode($log["attachments"]),
                question: $log["question"] ?? "-"
            )
        )->toArray(), studentCaringObject: []);
    }
}
