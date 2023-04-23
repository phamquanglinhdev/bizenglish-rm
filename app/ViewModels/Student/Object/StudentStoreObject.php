<?php

namespace App\ViewModels\Student\Object;

class StudentStoreObject
{
    public function __construct(
        private readonly string  $code,
        private readonly string  $name,
        private readonly string  $email,
        private readonly ?string $student_parent,
        private readonly string  $phone,
        private readonly ?string $facebook,
        private readonly ?string $address,
        private readonly int     $student_status,
        private readonly int     $staff_id,
        private readonly string  $password,
        private readonly ?array   $extra,
        private readonly ?array   $files,
    )
    {
    }

    /**
     * @return ?array
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @return ?array
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'student_parent' => $this->getStudentParent(),
            'phone' => $this->getPhone(),
            'facebook' => $this->getFacebook(),
            'type' => 3,
            'address' => $this->getAddress(),
            'student_status' => $this->getStudentStatus(),
            'staff_id' => $this->getStaffId(),
            'extra' => json_encode($this->getExtra()),
            'files' => json_encode($this->getFiles()),
            'password' => $this->getPassword()
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
    public function getStudentParent(): ?string
    {
        return $this->student_parent;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
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
    public function getStudentStatus(): int
    {
        return $this->student_status;
    }

    /**
     * @return int
     */
    public function getStaffId(): int
    {
        return $this->staff_id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
