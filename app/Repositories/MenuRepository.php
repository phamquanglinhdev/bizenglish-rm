<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository extends CrudRepository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}
