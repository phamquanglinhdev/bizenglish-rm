<?php

namespace App\Services;

use App\Contract\CrudServicesInterface;
use App\Repositories\BookRepository;
use App\Repositories\MenuRepository;
use App\ViewModels\Menu\Object\MenuRecursiveObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class BookServices implements CrudServicesInterface
{

    public function __construct(
        readonly private MenuRepository $menuRepository,

    )
    {
    }

    /**
     * @return MenuRecursiveObject
     */
    public function setupListOperation(): MenuRecursiveObject
    {
        return new MenuRecursiveObject(
            name: "Menu gốc", id: -1, children: $this->menuRepository->getMenuRecursive(), books: Collection::make([])
        );
    }

    /**
     * @return mixed
     */
    public function setupFilterOperation()
    {
        // TODO: Implement setupFilterOperation() method.
    }

    /**
     * @return mixed
     */
    public function setupCreateOperation()
    {
        // TODO: Implement setupCreateOperation() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setupEditOperation($id)
    {
        // TODO: Implement setupEditOperation() method.
    }
}
