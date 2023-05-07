<?php

namespace App\ViewModels\Common;

class TimeObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $grade,
        private readonly string $time,
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getGrade(): string
    {
        return $this->grade;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }
}
