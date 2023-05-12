<?php

namespace App\ViewModels\Teacher\Object;

use App\ViewModels\Common\UserRelationObject;

class TeacherLogsObject
{
    public function __construct(
        readonly private string             $id,
        readonly private string             $title,
        readonly private UserRelationObject $teacher,
        readonly private string             $date,
        readonly private string             $question,
        readonly private ?array             $attachments
    )
    {
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
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return UserRelationObject
     */
    public function getTeacher(): UserRelationObject
    {
        return $this->teacher;
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
    public function getId(): string
    {
        return $this->id;
    }
}
