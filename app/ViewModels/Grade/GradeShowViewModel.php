<?php

namespace App\ViewModels\Grade;

use App\Models\Grade;
use App\ViewModels\Grade\Object\GradeShowObject;
use App\ViewModels\Grade\Object\LogGradeObject;
use Illuminate\Database\Eloquent\Collection;

class GradeShowViewModel
{
    public function __construct(
        private readonly GradeShowObject $grade,
        private readonly mixed  $logs
    )
    {
    }

    /**
     * @return GradeShowObject
     */
    public function getGrade(): GradeShowObject
    {
        return $this->grade;
    }

    /**
     * @return LogGradeObject[]
     */
    public function getLogs(): mixed
    {
        return $this->logs;
    }

}
