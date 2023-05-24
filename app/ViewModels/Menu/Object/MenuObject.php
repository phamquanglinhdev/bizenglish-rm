<?php

namespace App\ViewModels\Menu\Object;

use App\Untils\DataBroTable;

class MenuObject
{
    public function __construct(
        private readonly int    $id,
        private readonly string $name,
        private readonly string $parent
    )
    {
    }

    public function toArray():array
    {
        return [
            'name'=>$this->getName(),
            'parent'=>$this->getParent(),
            'action' => DataBroTable::cView("actions", ['entry' => 'menus', 'id' => $this->getId()])
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getParent(): string
    {
        return $this->parent;
    }
}
