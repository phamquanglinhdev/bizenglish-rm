<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PHPUnit\Exception;

abstract class CrudRepository
{
    public mixed $model;

    public function setQuery($query)
    {
        return $this->model = $query->query;
    }

    public function getQuery(): Builder
    {
        return $this->model->query();
    }

    public function filter(Builder $query, array $attributes): Builder
    {
        return $query;
    }

    public function index($attributes): Collection|array
    {

        $crud = $this->filter($this->getQuery(), $attributes);
        $crud = $this->filter($crud, $attributes);
        if (isset($attributes['length'])) {
            if ($attributes['length'] != -1) {
                if (isset($attributes['start'])) {
                    $crud->skip($attributes['start']);
                    $crud->take($attributes['length']);
                }
            }
        }
        try {
            return $crud->where("disable", 0)->orderBy("created_at", "DESC")->get();
        } catch (Exception $exception) {
            return $crud->orderBy("created_at", "DESC")->get();
        }

    }

    public function indexNoDisable($attributes): Collection|array
    {
        $crud = $this->filter($this->getQuery(), $attributes);
        $crud = $this->filter($crud, $attributes);
        if (isset($attributes['length'])) {
            if ($attributes['length'] != -1) {
                if (isset($attributes['start'])) {
                    $crud->skip($attributes['start']);
                    $crud->take($attributes['length']);
                }
            }
        }
        return $crud->orderBy("created_at", "DESC")->get();
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
        return $this->getQuery()->where("id", $id)->update(["disable" => 1]);
    }

    public function forceDelete(string $id): int
    {
        return $this->getQuery()->where("id", $id)->delete();
    }

    public function getForSelect($trash = true): array
    {
        if($trash){
            return $this->getQuery()->where("disable", 0)->get()->pluck("name", "id")->toArray();
        }
        else {
            return $this->getQuery()->get()->pluck("name", "id")->toArray();
        }
    }


    public function syncRelation(Model|Builder $collection, $relationName, array $relationValue)
    {
        return $collection->{$relationName}()->sync($relationValue);
    }


    public function count($attributes): int
    {
        $crud = $this->filter($this->getQuery(), $attributes);
        try {
            return $crud->where("disable", 0)->count();
        } catch (\Exception $exception) {
            return $crud->count();
        }
    }

    public function countNoDisable($attributes): int
    {
        $crud = $this->filter($this->getQuery(), $attributes);
        return $crud->count();
    }

}
