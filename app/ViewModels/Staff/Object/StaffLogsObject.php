<?php

namespace App\ViewModels\Staff\Object;

use App\ViewModels\Common\UserRelationObject;

class StaffLogsObject
{
    public function __construct(
        private readonly string $title,
        private readonly string $id,
        private readonly string $date,
        private readonly UserRelationObject $teacher,
        private readonly array  $attachments,
        private readonly string $question
    )
    {

    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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
     * @return UserRelationObject
     */
    public function getTeacher(): UserRelationObject
    {
        return $this->teacher;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
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
}
