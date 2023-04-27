<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends CrudRepository
{
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }
}
