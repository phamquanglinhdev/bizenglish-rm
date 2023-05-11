<?php

namespace App\ViewModels\Staff\Object;

class StaffShowObject
{
    public function __construct(
        private readonly int    $id,
        private readonly string $code,
        private readonly string $name,
        private readonly string $job,
        private readonly string $phone,
        private readonly string $email,
        private readonly array  $extra,
        private readonly string $avatar,
    )
    {
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getJob(): string
    {
        return $this->job;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}
