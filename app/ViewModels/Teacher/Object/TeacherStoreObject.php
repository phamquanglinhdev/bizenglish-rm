<?php

namespace App\ViewModels\Teacher\Object;

class TeacherStoreObject
{
    public function __construct(
        private readonly string  $code,
        private readonly string  $name,
        private readonly ?int    $partner_id,
        private readonly string  $email,
        private readonly ?string $facebook,
        private readonly ?string $address,
        private readonly ?string $video,
        private readonly ?string $cv,
        private readonly ?string $phone,
        private readonly ?array  $extra,
        private readonly ?array  $files,
        private readonly string  $password,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'partner_id' => $this->getPartnerId(),
            'email' => $this->getEmail(),
            'facebook' => $this->getFacebook(),
            'address' => $this->getAddress(),
            'video' => $this->getVideo(),
            'cv' => $this->getCv(),
            'phone' => $this->getPhone(),
            'extra' => json_encode($this->getExtra()),
            'files' => json_encode($this->getFiles()),
            'password' => $this->getPassword(),
            'type' => 1,
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
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->partner_id;
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
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @return string|null
     */
    public function getCv(): ?string
    {
        return $this->cv;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
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
