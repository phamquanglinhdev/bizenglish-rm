<?php

namespace App\ViewModels\Menu;

use App\Models\Menu;
use App\ViewModels\Menu\Object\MenuObject;
use Illuminate\Database\Eloquent\Collection;

class MenuListViewModel
{
    public function __construct(
        private readonly Collection $menus,
        private readonly string     $label,
    )
    {
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return MenuObject[]
     */
    public function getMenus(): array
    {
        return $this->menus->map(fn(Menu $menu) => (new MenuObject(
            id: $menu["id"],
            name: $menu["name"],
            parent: $menu->parent()->first()->name ?? "-"))->toArray()
        )->toArray();
    }
}
