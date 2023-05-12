<?php

namespace App\ViewModels\Teacher\Object;

class LogShowGradeObject
{
    public function __construct(
        readonly private string $id,
        readonly private string $name,
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
