<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends CrudRepository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}
