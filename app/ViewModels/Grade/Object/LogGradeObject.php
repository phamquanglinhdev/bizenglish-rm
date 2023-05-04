<?php

namespace App\ViewModels\Grade\Object;

use Illuminate\Support\Carbon;

class LogGradeObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $date,
        private readonly string  $start,
        private readonly string  $end,
        private readonly ?string  $teacher,
        private readonly string  $lesson,
        private readonly ?string $teacher_video,
        private readonly ?string $drive,
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
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end;
    }

    /**
     * @return object|null
     */
    public function getTeacher(): ?object
    {
        return json_decode($this->teacher??null);
    }

    /**
     * @return string
     */
    public function getLesson(): string
    {
        return $this->lesson;
    }

    /**
     * @return string|null
     */
    public function getTeacherVideo(): ?object
    {
        return json_decode($this->teacher_video);
    }

    /**
     * @return string|null
     */
    public function getDrive(): ?string
    {
        return $this->drive;
    }

    /**
     * @return string
     */



}
