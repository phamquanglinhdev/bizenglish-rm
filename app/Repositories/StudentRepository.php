<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends CrudRepository
{

    public function __construct(Student $student)
    {
        $this->model = $student;
    }
}
