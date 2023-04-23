<?php

namespace App\ViewModels\Student\Object;

use App\Untils\DataBroTable;

class StudentListObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $status,
        private readonly string  $code,
        private readonly string  $name,
        private readonly ?string $staff,
        private readonly ?string $supporter,
        private readonly ?string $student_parent,
        private readonly ?array  $grades,
        private readonly string  $email,
        private readonly ?string $phone,
    )
    {
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->getStatus(),
            'code' => DataBroTable::cView("primary", ['entry' => 'students', 'id' => $this->getId(), 'name' => $this->getCode()]),
            'name' => DataBroTable::cView("primary", ['entry' => 'students', 'id' => $this->getId(), 'name' => $this->getName()]),
            'staff' => DataBroTable::cView("belongTo", ['entry' => 'staffs', 'object' => $this->getStaff()]),
            'supporter' => DataBroTable::cView("belongTo", ['entry' => 'staffs', 'object' => $this->getSupporter()]),
            'student_parent' => $this->getStudentParent(),
            'phone' => $this->getPhone(),
            'grades' => DataBroTable::cView("belongToMany", ['entry' => 'grades', 'objects' => $this->getGrades()]),
            'email' => $this->getEmail(),
            'action' => DataBroTable::cView("actions", ['entry' => 'students', 'id' => $this->getId()])
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getStaff(): ?string
    {
        return $this->staff;
    }

    /**
     * @return string|null
     */
    public function getSupporter(): ?string
    {
        return $this->supporter;
    }

    /**
     * @return string|null
     */
    public function getStudentParent(): ?string
    {
        return $this->student_parent;
    }

    /**
     * @return array|null
     */
    public function getGrades(): ?array
    {
        return $this->grades;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
