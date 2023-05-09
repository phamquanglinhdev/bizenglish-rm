<?php

namespace App\ViewModels\Grade\Object;

use App\Untils\DataBroTable;
use Illuminate\Support\Collection;

class GradeListObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $students,
        private readonly string $teachers,
        private readonly string $staffs,
        private readonly string $supporters,
        private readonly string $clients,
        private readonly string $link,
        private readonly int    $pricing,
        private readonly int    $minutes,
        private readonly int    $remaining,
        private readonly string $attachment,
        private readonly string $status,
        private readonly string $created_at,
    )
    {
    }

    /**
     * @return string
     */
    public function getStaffs(): string
    {
        return $this->staffs;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getStudents(): string
    {
        return $this->students;
    }

    /**
     * @return string
     */
    public function getTeachers(): string
    {
        return $this->teachers;
    }

    /**
     * @return string
     */
    public function getSupporters(): string
    {
        return $this->supporters;
    }

    /**
     * @return string
     */
    public function getClients(): string
    {
        return $this->clients;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return int
     */
    public function getPricing(): int
    {
        return $this->pricing;
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
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->attachment;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function toArray(): array
    {
        return Collection::make([
            'id' => $this->getId(),
            'name' => DataBroTable::cView("name", ['entry' => 'grades', 'collection' => ['name' => $this->getName(), 'id' => $this->getId()]]),
            'students' => $this->getStudents(),
            'teachers' => $this->getTeachers(),
            'staffs' => $this->getStaffs(),
            'supporters' => $this->getSupporters(),
            'clients' => $this->getClients(),
            'link' => DataBroTable::cView("link", ["link" => $this->getLink()]),
            'pricing' => number_format($this->getPricing()),
            'minutes' => number_format($this->getMinutes()),
            'remaining' => number_format($this->getRemaining()),
            'attachment' => $this->getAttachment(),
            'status' => $this->getStatus(),
            'created_at' => $this->getCreatedAt(),
            'action' => DataBroTable::cView("actions", ['entry' => 'grades', 'id' => $this->getId()])
        ])->toArray();
    }

}
