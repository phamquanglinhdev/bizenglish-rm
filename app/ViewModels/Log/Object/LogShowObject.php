<?php

namespace App\ViewModels\Log\Object;

class LogShowObject
{
    public function __construct(
        private readonly string           $id,
        private readonly string           $embed,
        private readonly string           $date,
        private readonly string           $time,
        private readonly string           $title,
        private readonly LogGradeObject   $grade,
        private readonly TeacherLogObject $teacher,
        private readonly ?array           $students,
        private readonly ?string           $assessment,
    )
    {
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
    public function getTime(): string
    {
        return $this->time;
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
    public function getEmbed(): string
    {
        return $this->embed;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return LogGradeObject
     */
    public function getGrade(): LogGradeObject
    {
        return $this->grade;
    }

    /**
     * @return TeacherLogObject
     */
    public function getTeacher(): TeacherLogObject
    {
        return $this->teacher;
    }

    /**
     * @return StudentLogObject[]|null
     */
    public function getStudents(): ?array
    {
        return $this->students;
    }

    /**
     * @return ?string
     */
    public function getAssessment(): ?string
    {
        return $this->assessment;
    }
}
