<?php

namespace App\ViewModels\Client\Object;

class ClientStoreObject
{
    public function __construct(
        private readonly string  $code,
        private readonly string  $name,
        private readonly string  $email,
        private readonly string  $phone,
        private readonly ?string $facebook,
        private readonly int     $client_status,
        private readonly ?array  $extra,
        private readonly ?array  $files,
        private readonly string  $password
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
            'facebook' => $this->getFacebook(),
            'client_status' => $this->getClientStatus(),
            'type' => 2,
            'extra' => json_encode($this->getExtra()),
            'files' => json_encode($this->getFiles()),
            'password' => json_encode($this->getPassword())
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
     * @return int
     */
    public function getClientStatus(): int
    {
        return $this->client_status;
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
