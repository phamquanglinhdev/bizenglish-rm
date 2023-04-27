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
        private readonly string  $teacher,
        private readonly ?string $partner,
        private readonly string  $lesson,
        private readonly ?string $teacher_video,
        private readonly ?string $drive,
        private readonly int     $duration,
        private readonly int     $hour_salary,
        private readonly int     $log_salary,
        private readonly string  $status,
        private readonly ?string  $assessment,
        private readonly ?string  $attachments,
        private readonly ?string $confirm,
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
        return Carbon::parse($this->date)->isoFormat("DD-MM-YYYY");
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
     * @return string
     */
    public function getTeacher(): string
    {
        return $this->teacher;
    }

    /**
     * @return string|null
     */
    public function getPartner(): ?string
    {
        return $this->partner;
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
    public function getTeacherVideo(): ?string
    {
        return $this->teacher_video;
    }

    /**
     * @return string|null
     */
    public function getDrive(): ?string
    {
        return $this->drive;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getHourSalary(): int
    {
        return $this->hour_salary;
    }

    /**
     * @return int
     */
    public function getLogSalary(): int
    {
        return $this->log_salary;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getAssessment(): ?string
    {
        return $this->assessment;
    }

    /**
     * @return string|null
     */
    public function getAttachments(): ?string
    {
        return $this->attachments;
    }

    /**
     * @return string|null
     */
    public function getConfirm(): ?string
    {
        return $this->confirm;
    }


}
