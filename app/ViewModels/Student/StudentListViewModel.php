<?php

namespace App\ViewModels\Student;

class StudentListViewModel
{
    public function __construct(
        private readonly array $students
    )
    {
    }

    /**
     * @return array
     */
    public function getStudents(): array
    {
        return $this->students;
    }
}
