<?php

namespace App\ViewModels\Customer;

class CustomerListViewModel
{
    public function __construct(
        private readonly array $customers
    )
    {
    }

    /**
     * @return array
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }
}
