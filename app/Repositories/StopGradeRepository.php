<?php

namespace App\Repositories;

use App\Models\StopGrade;

class StopGradeRepository extends CrudRepository
{
    public function __construct(StopGrade $grade)
    {
        $this->model = $grade;
    }
}
