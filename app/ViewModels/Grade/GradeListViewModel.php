<?php

namespace App\ViewModels\Grade;

use Ramsey\Collection\Collection;

class GradeListViewModel
{
    public function __construct(
        private readonly array $grades,
        private readonly string $label,
    )
    {
    }

    /**
     * @return array
     */
    public function getGrades():array
    {
        return $this->grades;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

}
