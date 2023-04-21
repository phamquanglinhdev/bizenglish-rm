<?php

namespace App\ViewModels\Log;


class LogListViewModel
{
    public function __construct(
        private readonly array  $logs,
        private readonly string $label,
    )
    {
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
