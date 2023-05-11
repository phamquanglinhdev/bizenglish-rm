<?php

namespace App\ViewModels\Log\Object;

class RecommendLogObject
{
    public function __construct(
        private readonly string $id,
        private readonly ?string $teacher,
        private readonly string $title,
        private readonly string $date,
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
     * @return string|null
     */
    public function getTeacher(): ?string
    {
        return $this->teacher??null;
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
    public function getDate(): string
    {
        return $this->date;
    }
}
