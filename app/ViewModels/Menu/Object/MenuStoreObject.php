<?php

namespace App\ViewModels\Menu\Object;

class MenuStoreObject
{
    public function __construct(
        private readonly string $name,
        private readonly ?int   $parent_id
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
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'parent_id' => $this->getParentId() ?? null
        ];
    }
}
