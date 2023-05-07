<?php

namespace App\ViewModels\Student\Object;

use App\ViewModels\Common\UserRelationObject;

class StudentLogsObject
{
    public function __construct(
        private readonly string $title,
        private readonly string $id,
        private readonly string $date,
        private readonly string $teacher,
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
     * @return object
     */
    public function getTeacher(): object
    {
        $teacher = json_decode($this->teacher);
        return new UserRelationObject(
            id: $teacher->id,
            name: $teacher->name,
            avatar: $teacher->avatar??"https://e2.yotools.net/images/user_image/2023/05/6457555910168.jpg",
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
