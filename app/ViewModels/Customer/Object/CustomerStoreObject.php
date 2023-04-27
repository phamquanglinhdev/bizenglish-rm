<?php

namespace App\ViewModels\Customer\Object;

class CustomerStoreObject
{
    public function __construct(
        private readonly string  $code,
        private readonly string  $name,
        private readonly string  $email,
        private readonly ?string $phone,
        private readonly ?string $address,
        private readonly int     $staff_id,
        private readonly int     $student_status,
        private readonly ?array  $extra,
        private readonly ?array  $files,
        private readonly string  $password,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'address' => $this->getAddress(),
            'staff_id' => $this->getStaffId(),
            'student_status' => $this->getStudentStatus(),
            'extra' => json_encode($this->getExtra()),
            'files' => json_encode($this->getFiles()),
            'password' => json_encode($this->getPassword()),
            'type' => 4,
        ];
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getStaffId(): int
    {
        return $this->staff_id;
    }

    /**
     * @return int
     */
    public function getStudentStatus(): int
    {
        return $this->student_status;
    }

    /**
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @return array|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
