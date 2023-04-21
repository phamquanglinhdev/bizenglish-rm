<?php

namespace App\Repositories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GradeRepository extends CrudRepository
{

    public function __construct(Grade $grade)
    {
        $this->model = $grade;
    }

    public function index($filters = []): Collection|array
    {
        if (array_key_exists("name", $filters)) {
            $value = $filters["name"];
            $this->model = $this->model->where("name", "like", "%$value%");
        }
        return $this->getQuery()->where("disable", 0)->orderBy("created_at", "DESC")->get();
    }

}
