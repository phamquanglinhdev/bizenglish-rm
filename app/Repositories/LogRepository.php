<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class LogRepository extends CrudRepository
{
    public function __construct(Log $log)
    {
        $this->model = $log;
    }

    /**
     * @param Builder $query
     * @param array $attributes
     * @return Builder
     */
    public function filter(Builder $query, array $attributes): Builder
    {
        $query->whereHas("grade", function (Builder $builder) {
            $builder->where("disable", 0);
        });
        if (isset($attributes['grade'])) {
            $value = $attributes["grade"];
            $query->whereHas("grade", function (Builder $grade) use ($value) {
                $grade->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['student'])) {
            $value = $attributes["student"];
            $query->whereHas("grade", function (Builder $grade) use ($value) {
                $grade->whereHas("students", function (Builder $student) use ($value) {
                    $student->where("name", "like", "%$value%");
                });
            });
        }
        if (isset($attributes['teacher'])) {
            $value = $attributes["teacher"];
            $query->whereHas("teacher", function (Builder $teacher) use ($value) {
                $teacher->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['client'])) {
            $value = $attributes["grade"];
            $query->whereHas("grade", function (Builder $grade) use ($value) {
                $grade->where("name", "like", "%$value%");
            });
        }
        if (isset($attributes['client'])) {
            $value = $attributes["client"];
            $query->whereHas("grade", function (Builder $grade) use ($value) {
                $grade->whereHas("clients", function (Builder $client) use ($value) {
                    $client->where("name", "like", "%$value%");
                });
            });
        }
        if (isset($attributes['partner'])) {
            $value = $attributes["partner"];
            $query->whereHas("teacher", function (Builder $teacher) use ($value) {
                $teacher->whereHas("partner", function (Builder $partner) use ($value) {
                    $partner->where("name", "like", "%$value%");
                });
            });
        }
        if (isset($attributes['status'])) {
            if ($attributes["status"] != "all") {
                $value = $attributes["status"];
                $query->where("status", "like", "%\"name\":\"$value\"%");
            }
        }
        if (isset($attributes['date'])) {
            $value = $attributes['date'];
            $start = explode("/", trim(explode("-", $value)[0]));
            $startTime = Carbon::create($start[2], $start[1], $start[0]);
            $end = explode("/", trim(explode("-", $value)[1]));
            $endTime = Carbon::create($end[2], $end[1], $end[0])->endOfDay();

            $query->where("date", ">=", $startTime)->where("date", "<=", $endTime);
        }
        return $query;
    }

    public function getLogByGrade($gradeId): Collection|array
    {
        return $this->getQuery()->whereHas("grade", function (Builder $grade) use ($gradeId) {
            $grade->where("id", $gradeId);
        })->orderBy("created_at", "DESC")->get();
    }

    public function getLogByGrades(array $grades): Collection|array
    {
        return $this->getQuery()->whereHas("grade", function (Builder $grade) use ($grades) {
            $grade->whereIn("id", $grades);
        })->orderBy("updated_at", "DESC")->limit(50)->get();
    }
}
