<?php

namespace App\ViewModels\Common;

class UserRelationObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $avatar,
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

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
