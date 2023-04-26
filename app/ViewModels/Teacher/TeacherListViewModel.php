<?php

namespace App\ViewModels\Teacher;

class TeacherListViewModel
{
    public function __construct(
        private readonly array $teachers
    )
    {
    }

    /**
     * @return array
     */
    public function getTeachers(): array
    {
        return $this->teachers;
    }
}
