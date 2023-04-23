<?php

namespace App\ViewModels\Staff\Object;

use App\Untils\DataBroTable;

class StaffListObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $name,
        private readonly string $job,
        private readonly string $phone,
        private readonly string $email,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'job' => $this->getJob(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'action' => DataBroTable::cView("actions",['entry' => 'staffs', 'id' => $this->getId()])
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
    public function getType(): string
    {
        return $this->type;
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
}
