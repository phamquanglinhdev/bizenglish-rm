<?php

namespace App\ViewModels\Client\Object;

use App\Untils\DataBroTable;

class ClientListObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $client_status,
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
            'client_status' => $this->getClientStatus(),
            'action' => DataBroTable::cView("actions", ['entry' => 'clients', 'id' => $this->getId()])

        ];
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
    public function getClientStatus(): string
    {
        return $this->client_status;
    }
}
