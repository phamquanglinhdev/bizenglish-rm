<?php

namespace App\Repositories;

use App\Models\Menu;
use App\ViewModels\Menu\Object\MenuObject;
use App\ViewModels\Menu\Object\MenuRecursiveObject;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends CrudRepository
{
    public function __construct(Menu $menu, private readonly BookRepository $bookRepository
    )
    {
        $this->model = $menu;
    }

    public function getMenuRecursive($id = null): array
    {
        $menuChild = $this->getQuery()->where("parent_id", $id)->get();
        return $menuChild->map(fn(Menu $menu) => new MenuRecursiveObject(
            name: $menu["name"], id: $menu["id"],
            children: $this->getMenuRecursive($menu["id"]),
            books: $this->bookRepository->getByMenu(menuId: $menu["id"])
        ))->toArray();

    }
}
