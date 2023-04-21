<?php

namespace App\Repositories;

use App\Models\Supporter;

class SupporterRepository extends CrudRepository
{
    public function __construct(Supporter $supporter)
    {
        $this->model = $supporter;
    }
}
