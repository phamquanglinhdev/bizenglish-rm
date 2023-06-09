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

    /**
     * @param Builder $query
     * @param array $attributes
     * @return Builder
     */
    public function filter(Builder $query, array $attributes): Builder
    {
        if (isset($attributes['name'])) {
            $value = $attributes["name"];
            $query->where("name", "like", "%$value%");
        }
        if (isset($attributes['staffs'])) {
            $value = $attributes["staffs"];
            $query->whereHas("staffs", function (Builder $staffs) use ($value) {
                $staffs->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['supporters'])) {
            $value = $attributes["supporters"];
            $query->whereHas("supporters", function (Builder $supporters) use ($value) {
                $supporters->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['students'])) {
            $value = $attributes["students"];
            $query->whereHas("students", function (Builder $student) use ($value) {
                $student->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['teachers'])) {
            $value = $attributes["teachers"];
            $query->whereHas("teachers", function (Builder $teachers) use ($value) {
                $teachers->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['clients'])) {
            $value = $attributes["clients"];
            $query->whereHas("clients", function (Builder $clients) use ($value) {
                $clients->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['status'])) {
            $value = $attributes["status"];
            $query->where("status", $value);
        }
        if (isset($attributes['remaining'])) {
            $value = $attributes['remaining'];
            /**
             * @var Collection $grades
             * @var Grade $grade
             * @var array $elde
             * @var array $few
             * @var array $expired
             */
            $elde = [];
            $few = [];
            $expired = [];
            $grades = $this->index([]);
            foreach ($grades as $grade) {
                $durations = $grade->Logs()->sum("duration");
                $remaining = $grade->minutes - $durations;
                if ($remaining >= 90) {
                    $elde[] = $grade->id;
                } else if ($remaining > 0) {
                    $few[] = $grade->id;
                } else {
                    $expired[] = $grade->id;
                }
            }
            switch ($value) {
                case 0:
                    $query->where(function (Builder $builder) use ($elde) {
                        $builder->whereIn("id", $elde);
                    });
                    break;
                case 1:
                    $query->where(function (Builder $builder) use ($few) {
                        $builder->whereIn("id", $few);
                    });
                    break;
                case 2:
                    $query->where(function (Builder $builder) use ($expired) {
                        $builder->whereIn("id", $expired);
                    });
                    break;
                default:
                    break;
            }
        }
        return $query;
    }


}
