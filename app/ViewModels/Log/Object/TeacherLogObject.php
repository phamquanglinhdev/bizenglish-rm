<?php

namespace App\ViewModels\Log\Object;

class TeacherLogObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
