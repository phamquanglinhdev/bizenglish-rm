<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;

class StudentRepository extends CrudRepository
{

    public function __construct(Student $student)
    {
        $this->model = $student;
    }

}
