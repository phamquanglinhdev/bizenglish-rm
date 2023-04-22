<?php

namespace App\ViewModels\Log\Object;

use App\Untils\DataBroTable;
use Illuminate\Support\Collection;

class LogListObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $grade,
        private readonly string  $date,
        private readonly string  $start,
        private readonly string  $end,
        private readonly string  $teacher,
        private readonly array   $students,
        private readonly array   $clients,
        private readonly ?string $partner,
        private readonly string  $lesson,
        private readonly ?string $teacher_video,
        private readonly ?string $drive,
        private readonly int     $duration,
        private readonly int     $hour_salary,
        private readonly int     $log_salary,
        private readonly string  $status,
        private readonly ?string $assessment,
        private readonly ?array  $attachments,
        private readonly string  $confirm,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'grade' => $this->getGrade(),
            'date' => $this->getDate(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'teacher' => $this->getTeacher(),
            'students' => $this->getStudents(),
            'clients' => $this->getClients(),
            'lesson' => DataBroTable::cView("text", ['text' => $this->getLesson(), "limit" => 40]),
            'partner' => $this->getPartner(),
            'teacher_video' => (string)view("admin.operations.columns.video", ['video' => $this->getTeacherVideo()]),
            'drive' => (string)view("admin.operations.columns.drive", ['link' => $this->getDrive()]),
            'duration' => $this->getDuration(),
            'hour_salary' => number_format($this->getHourSalary()),
            'log_salary' => number_format($this->getLogSalary()),
            'status' => $this->getStatus(),
            'assessment' => DataBroTable::cView("text", ['text' => $this->getAssessment()]),
            'attachments' => "-",
            'confirm' => $this->getConfirm(),
            'action' => (string)view("admin.operations.columns.actions", ['entry' => 'logs', 'id' => $this->getId()])
        ];
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
     * @return object
     */
    public function getTeacher(): string
    {
        return $this->teacher;
    }

    /**
     * @return array
     */
    public function getStudents(): array
    {
        return $this->students;
    }

    /**
     * @return array
     */
    public function getClients(): array
    {
        return $this->clients;
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
     * @return array|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * @return string
     */
    public function getConfirm(): string
    {
        return $this->confirm;
    }


    private function getGrade(): string
    {
        return $this->grade;
    }
}
