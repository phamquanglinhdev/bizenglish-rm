<?php

namespace App\ViewModels\Book\Object;

class BookListObject
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $thumbnail,
        private readonly string $link
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
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
