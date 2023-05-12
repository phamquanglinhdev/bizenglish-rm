<?php

namespace App\ViewModels\Log\Object;

use Carbon\Carbon;

class LogStoreObject
{
    public function __construct(
        private readonly int     $grade_id,
        private readonly int     $teacher_id,
        private readonly string  $date,
        private readonly string  $start,
        private readonly string  $end,
        private readonly ?int    $number_of_student,
        private readonly int     $duration,
        private readonly int     $hour_salary,
        private readonly int     $log_salary,
        private readonly string  $lesson,
        private readonly ?string $teacher_video,
        private readonly ?string $drive,
        private readonly ?string $information,
        private readonly string  $status,
        private readonly ?string $assessment,
        private readonly ?string $question,
        private readonly ?string $attachments,
    )
    {
    }

    /**
     * @return int|null
     */
    public function getNumberOfStudent(): ?int
    {
        return $this->number_of_student;
    }

    public function toArray(): array
    {
        return [
            'grade_id' => $this->getGradeId(),
            'teacher_id' => $this->getTeacherId(),
            'date' => Carbon::parse($this->getDate()),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'duration' => $this->getDuration(),
            'hour_salary' => $this->getHourSalary(),
            'log_salary' => $this->getLogSalary(),
            'lesson' => $this->getLesson(),
            'teacher_video' => $this->getTeacherVideo(),
            'drive' => $this->getDrive(),
            'information' => $this->getInformation() ?? "Không có",
            'status' => $this->getStatus(),
            'number_of_student' => $this->getNumberOfStudent(),
            'assessment' => $this->getAssessment(),
            'attachments' => $this->getAttachments(),
        ];
    }

    /**
     * @return int
     */
    public function getGradeId(): int
    {
        return $this->grade_id;
    }

    /**
     * @return int
     */
    public function getTeacherId(): int
    {
        return $this->teacher_id;
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
     * @return string|null
     */
    public function getInformation(): ?string
    {
        return $this->information;
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
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @return string|null
     */
    public function getAttachments(): ?string
    {
        return $this->attachments;
    }

}
