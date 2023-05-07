<?php

namespace App\ViewModels\Student\Object;

use App\ViewModels\Common\UserRelationObject;
use Illuminate\Support\Str;

class StudentLogsObject
{
    public function __construct(
        private readonly string $title,
        private readonly string $id,
        private readonly string $date,
        private readonly ?string $teacher,
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
        return Str::limit($this->title,50);
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
     * @return ?object
     */
    public function getTeacher(): ?object
    {
        $teacher = json_decode($this->teacher);
        return new UserRelationObject(
            id: $teacher->id??0,
            name: $teacher->name??"",
            avatar: $teacher->avatar??config("app.blank_avatar"),
        );
    }

    /**
     * @return object[]
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
