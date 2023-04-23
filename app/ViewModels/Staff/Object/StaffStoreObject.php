<?php

namespace App\ViewModels\Staff\Object;

class StaffStoreObject
{
    public function __construct(
        private readonly string  $code,
        private readonly string  $name,
        private readonly string  $job,
        private readonly string  $email,
        private readonly ?string $phone,
        private readonly ?string $facebook,
        private readonly ?string $address,
        private readonly ?array  $extra,
        private readonly string  $password,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'type' => 0,
            'name' => $this->getName(),
            'job' => $this->getJob(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'facebook' => $this->getFacebook() ?? null,
            'address' => $this->getAddress() ?? null,
            'extra' => $this->getExtra() ?? null,
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
    public function getJob(): string
    {
        return $this->job;
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
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
