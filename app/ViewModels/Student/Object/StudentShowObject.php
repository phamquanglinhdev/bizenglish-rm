<?php

namespace App\ViewModels\Student\Object;

class StudentShowObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $name,
        private readonly string  $code,
        private readonly string  $phone,
        private readonly string  $parent,
        private readonly string  $avatar,
        private readonly ?string $facebook,
        private readonly ?string $address,
        private readonly string  $email,
        private readonly int     $logCount,
        private readonly int     $remaining,
        private readonly int     $minutes,
        private readonly string  $status,
    )
    {
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getLogCount(): int
    {
        return $this->logCount;
    }

    /**
     * @return int
     */
    public function getRemaining(): int
    {
        return $this->remaining;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
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
    public function getName(): string
    {
        return $this->name;
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
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
