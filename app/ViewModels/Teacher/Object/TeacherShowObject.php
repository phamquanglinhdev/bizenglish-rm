<?php

namespace App\ViewModels\Teacher\Object;


use Illuminate\Support\Collection;

class TeacherShowObject
{
    public function __construct(
        readonly private int        $id,
        readonly private string     $code,
        readonly private string     $name,
        readonly private array      $extra,
        readonly private string     $address,
        readonly private string     $avatar,
        readonly private string     $phone,
        readonly private ?string    $facebook,
        readonly private string     $email,
        readonly private Collection $skills,
    )
    {
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        return $this->skills->toArray();
    }

    /**
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
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
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
