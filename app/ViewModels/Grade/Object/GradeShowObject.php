<?php

namespace App\ViewModels\Grade\Object;

class GradeShowObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $name,
        private readonly ?array  $teachers,
        private readonly ?string $zoom,
        private readonly ?array  $students,
        private readonly ?array  $clients,
        private readonly ?array  $staffs,
        private readonly int     $minutes,
        private readonly int     $remaining,
        private readonly ?string $information,
        private readonly int     $pricing,
        private readonly ?string $attachment,
        private readonly ?string $created_at,
        private readonly ?array  $time,

    )
    {
    }

    /**
     * @return array|null
     */
    public function getTime(): ?array
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getTeachers(): ?array
    {
        return $this->teachers;
    }

    /**
     * @return string|null
     */
    public function getZoom(): ?string
    {
        return $this->zoom;
    }

    /**
     * @return array|null
     */
    public function getStudents(): ?array
    {
        return $this->students;
    }

    /**
     * @return array|null
     */
    public function getClients(): ?array
    {
        return $this->clients;
    }

    /**
     * @return array|null
     */
    public function getStaffs(): ?array
    {
        return $this->staffs;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
    }

    /**
     * @return int
     */
    public function getRemaining(): int
    {
        return $this->remaining;
    }

    /**
     * @return string|null
     */
    public function getInformation(): ?string
    {
        return $this->information;
    }

    /**
     * @return int
     */
    public function getPricing(): int
    {
        return $this->pricing;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

}
