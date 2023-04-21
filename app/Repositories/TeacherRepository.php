<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends CrudRepository
{

    public function __construct(Teacher $teacher)
    {
        $this->model = $teacher;
    }
}
