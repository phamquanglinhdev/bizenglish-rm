<?php

namespace App\ViewModels\Demo\Object;

use App\Untils\DataBroTable;

class DemoListObject
{
    public function __construct(
        private readonly int     $id,
        private readonly string  $date,
        private readonly string  $start,
        private readonly string  $end,
        private readonly string  $grade,
        private readonly string  $students,
        private readonly string  $teacher_id,
        private readonly ?string $staff_id,
        private readonly ?string $supporter_id,
        private readonly ?string $client_id,
        private readonly array   $customers,
        private readonly ?string $student_phone,
        private readonly ?string $facebook,
        private readonly string  $lesson,
        private readonly ?string $teacher_video,
        private readonly ?string $drive,
        private readonly ?int    $duration,
        private readonly ?int    $hour_salary,
        private readonly ?int    $log_salary,
        private readonly ?string $assessment,
        private readonly ?array  $attachments,
        private readonly string  $status
    )
    {
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTeacherId(): string
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
     * @return string
     */
    public function getGrade(): string
    {
        return $this->grade;
    }

    /**
     * @return string
     */
    public function getStudents(): string
    {
        return $this->students;
    }

    /**
     * @return string|null
     */
    public function getStaffId(): ?string
    {
        return $this->staff_id;
    }

    /**
     * @return string|null
     */
    public function getSupporterId(): ?string
    {
        return $this->supporter_id;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @return array
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /**
     * @return string|null
     */
    public function getStudentPhone(): ?string
    {
        return $this->student_phone;
    }

    /**
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * @return string
     */
    public function getLesson(): string
    {
        return $this->lesson;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @return int|null
     */
    public function getHourSalary(): ?int
    {
        return $this->hour_salary;
    }

    /**
     * @return int|null
     */
    public function getLogSalary(): ?int
    {
        return $this->log_salary;
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
        return $this->attachments ?? [];
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'date' => $this->getDate(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'grade' => $this->getGrade(),
            'students' => $this->getStudents(),
            'teacher_id' => DataBroTable::cView("belongTo", ['entry' => 'teachers', 'object' => $this->getTeacherId()]),
            'staff_id' => DataBroTable::cView("belongTo", ["entry" => "staffs", "object" => $this->getStaffId()]),
            "supporter_id" => DataBroTable::cView("belongTo", ["entry" => "staffs", "object" => $this->getSupporterId()]),
            "client_id" => DataBroTable::cView("belongTo", ["entry" => "clients", "object" => $this->getClientId()]),
            'customers' => DataBroTable::cView("belongToMany", ["entry" => "customers", "objects" => $this->getCustomers()]),
            "student_phone" => $this->getStudentPhone(),
            'facebook' => DataBroTable::cView("link", ["link" => $this->getFacebook()]),
            "lesson" => DataBroTable::cView("text", ["text" => $this->getLesson(), "limit" => 30]),
            'teacher_video' => (string)view("admin.operations.columns.video", ['video' => $this->getTeacherVideo()]),
            'drive' => (string)view("admin.operations.columns.drive", ['link' => $this->getDrive()]),
            "duration" => $this->getDuration(),
            'hour_salary' => $this->getHourSalary(),
            "log_salary" => $this->getLogSalary(),
            "assessment" => DataBroTable::cView("text", ["text" => $this->getAssessment(), "limit" => 30]),
            'attachments' => DataBroTable::cView("files", ['attachments' => $this->getAttachments()]),
            "status" => $this->getStatus(),
            'action' => (string)view("admin.operations.columns.actions", ['entry' => 'demos', 'id' => $this->getId()])
        ];
    }
}
