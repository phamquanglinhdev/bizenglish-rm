<?php

namespace App\Repositories;

use App\Models\Demo;

class DemoRepository extends CrudRepository
{
    /**
     * @param Demo $demo
     */
    public function __construct(Demo $demo)
    {
        $this->model = $demo;
    }
}
