<?php

namespace App\ViewModels\Entry;

class SetupEntry
{
    private array $setup;

    public function __construct()
    {
        $this->setup = [];
    }

    /**
     * @return array
     */
    public function getSetup(): array
    {
        return $this->setup;
    }

    public function addConfig($key, $value): void
    {
        $this->setup[$key] = $value;
    }
}
