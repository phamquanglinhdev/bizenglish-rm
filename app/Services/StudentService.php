<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Untils\DataBroTable;
use App\ViewModels\Staff\Object\StaffListObject;
use App\ViewModels\Staff\StaffListViewModel;
use App\ViewModels\Student\Object\StudentListObject;
use App\ViewModels\Student\StudentListViewModel;
use Illuminate\Http\JsonResponse;

class StudentService implements CrudServicesInterface
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
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
    public function setupCreateOperation()
    {
        // TODO: Implement setupCreateOperation() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setupEditOperation($id)
    {
        // TODO: Implement setupEditOperation() method.
    }

    public function list($attribute): JsonResponse
    {
        $count = $this->studentRepository->count($attribute);
        $studentCollection = $this->studentRepository->index($attribute);
        $studentListViewModel = new StudentListViewModel(
            students: $studentCollection->map(
                fn(Student $student) => (new StudentListObject(
                    id: $student['id'],
                    status: $student['student_status'],
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
}
