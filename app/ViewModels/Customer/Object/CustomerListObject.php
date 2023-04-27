<?php

namespace App\ViewModels\Customer\Object;

use App\Untils\DataBroTable;

class CustomerListObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $name,
        private readonly string $staff,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $student_status,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'staff' => DataBroTable::cView("belongTo", ['entry' => 'staffs', 'object' => $this->getStaff()]),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'student_status' => $this->getStudentStatus(),
            'action' => DataBroTable::cView("actions", ['entry' => 'customers', 'id' => $this->getId()])
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
     * @return string
     */
    public function getStaff(): string
    {
        return $this->staff;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getStudentStatus(): string
    {
        return $this->student_status;
    }
}
