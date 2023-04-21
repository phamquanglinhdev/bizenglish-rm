<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PHPUnit\Exception;

class CrudRepository
{
    public mixed $model;

    public function setQuery($query)
    {
        return $this->model = $query->query;
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function index($attributes): Collection|array
    {
        try {
            return $this->getQuery()->where("disable", 0)->orderBy("created_at", "DESC")->get();
        } catch (Exception $exception) {
            return $this->getQuery()->orderBy("created_at", "DESC")->get();
        }

    }

    public function show($id): Model|Builder
    {
        return $this->getQuery()->where("id", $id)->firstOrFail();
    }

    public function create(array $attributes): Model|Builder
    {
        return $this->getQuery()->create($attributes);
    }

    public function update(array $attributes, string $id): int
    {
        return $this->getQuery()->where("id", $id)->update($attributes);
    }

    public function delete(string $id): int
    {
        return $this->getQuery()->where("id", $id)->update(["disable", 1]);
    }

    public function getForSelect(): array
    {
        try {
            return $this->getQuery()->where("disable", 0)->get()->pluck("name", "id")->toArray();
        } catch (\Exception $exception) {
            return $this->getQuery()->get()->pluck("name", "id")->toArray();
        }
    }


    public function syncRelation(Model|Builder $collection, $relationName, array $relationValue)
    {
        return $collection->{$relationName}()->sync($relationValue);
    }

}
