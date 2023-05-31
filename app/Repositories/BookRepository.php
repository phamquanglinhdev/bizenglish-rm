<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository extends CrudRepository
{
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function getByMenu($menuId): Collection|array
    {
        return $this->getQuery()->where("menu_id", $menuId)->get();
    }
}
