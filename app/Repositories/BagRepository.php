<?php

namespace App\Repositories;

use App\Models\Bag;

class BagRepository extends CrudRepository
{
    public function __construct(Bag $bag)
    {
        $this->model = $bag;
    }
}
