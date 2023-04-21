<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository extends CrudRepository
{
    public function __construct(Log $log)
    {
        $this->model = $log;
    }
}
