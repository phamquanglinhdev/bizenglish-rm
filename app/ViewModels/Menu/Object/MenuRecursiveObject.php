<?php

namespace App\ViewModels\Menu\Object;
use App\Models\Book;
use App\ViewModels\Book\Object\BookListObject;
use Illuminate\Database\Eloquent\Collection;

class MenuRecursiveObject
{
    public function __construct(
        private readonly string     $name,
        private readonly int        $id,
        private readonly array      $children,
        private readonly Collection $books,
    )
    {
    }

    /**
     * @return BookListObject[]
     */
    public function getBooks(): array
    {
        return $this->books->map(fn(Book $book)=> new BookListObject(
            id: $book["id"], name: $book["name"], thumbnail: $book["thumbnail"], link: $book["link"]
        ))->toArray();
    }

    /**
     * @return MenuRecursiveObject[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}
