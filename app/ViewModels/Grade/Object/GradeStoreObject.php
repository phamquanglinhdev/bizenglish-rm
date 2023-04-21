<?php

namespace App\ViewModels\Grade\Object;

class GradeStoreObject
{
    public function __construct(
        private readonly string  $name,
        private readonly ?string $zoom,
        private readonly int     $pricing,
        private readonly int     $minutes,
        private readonly int     $status,
        private readonly ?string $time,
        private readonly ?string $information,
        private readonly ?string $attachment,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getZoom(): ?string
    {
        return $this->zoom;
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
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @return string|null
     */
    public function getInformation(): ?string
    {
        return $this->information;
    }

    /**
     * @return string|null
     */
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'zoom' => $this->getZoom(),
            'pricing' => $this->getPricing(),
            'minutes' => $this->getMinutes(),
            'status' => $this->getStatus(),
            'time' => $this->getTime(),
            'information' => $this->getInformation(),
            'attachment' => $this->getAttachment(),
        ];
    }
}
