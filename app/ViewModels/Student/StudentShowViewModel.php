<?php

namespace App\ViewModels\Student;

use App\ViewModels\Student\Object\StudentCasingsObject;
use App\ViewModels\Student\Object\StudentLogsObject;
use App\ViewModels\Student\Object\StudentShowObject;

class StudentShowViewModel
{
    public function __construct(
        private readonly StudentShowObject $student,
        private readonly array             $studentLogs,
        private readonly array             $studentCaringObject,
    )
    {
    }

    /**
     * @return StudentShowObject
     */
    public function getStudent(): StudentShowObject
    {
        return $this->student;
    }

    /**
     * @return StudentLogsObject[]
     */
    public function getStudentLogs(): array
    {
        return $this->studentLogs;
    }

    /**
     * @return StudentCasingsObject[]
     */
    public function getStudentCaringObject(): array
    {
        return $this->studentCaringObject;
    }
}
