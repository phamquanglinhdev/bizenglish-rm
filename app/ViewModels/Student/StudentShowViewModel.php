<?php

namespace App\ViewModels\Student;

use App\ViewModels\Common\CalendarObject;
use App\ViewModels\Student\Object\StudentCaringsObject;
use App\ViewModels\Student\Object\StudentLogsObject;
use App\ViewModels\Student\Object\StudentShowObject;

class StudentShowViewModel
{
    public function __construct(
        private readonly StudentShowObject $student,
        private readonly array             $studentLogs,
        private readonly array             $studentCaringObject,
        private readonly CalendarObject    $calendarObject,
    )
    {
    }

    /**
     * @return CalendarObject
     */
    public function getCalendarObject(): CalendarObject
    {
        return $this->calendarObject;
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
     * @return StudentCaringsObject[]
     */
    public function getStudentCaringObject(): array
    {
        return $this->studentCaringObject;
    }
}
