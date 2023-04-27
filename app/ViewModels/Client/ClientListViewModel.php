<?php

namespace App\ViewModels\Client;

class ClientListViewModel
{
    public function __construct(
        private readonly array $clients
    )
    {
    }

    /**
     * @return array
     */
    public function getClients(): array
    {
        return $this->clients;
    }

}
