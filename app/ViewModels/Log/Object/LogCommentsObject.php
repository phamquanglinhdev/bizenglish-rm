<?php

namespace App\ViewModels\Log\Object;

class LogCommentsObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $username,
        private readonly string $message,
        private readonly ?string $avatar
    )
    {
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
