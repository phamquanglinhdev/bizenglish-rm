<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LogScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (principal()->getType() == 0) {
            $builder->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("staffs", function (Builder $staffs) {
                    $staffs->where("id", principal()->getId());
                })->orWhereHas("supporters", function (Builder $supporters) {
                    $supporters->where("id", principal()->getId());
                });
            });
        }
        if (principal()->getType() == 1) {
            $builder->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("teachers", function (Builder $teachers) {
                    $teachers->where("id", principal()->getId());
                });
            });
        }
        if (principal()->getType() == 2) {
            $builder->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("clients", function (Builder $clients) {
                    $clients->where("id", principal()->getId());
                });
            });
        }
        if (principal()->getType() == 3) {
            $builder->whereHas("grade", function (Builder $grade) {
                $grade->whereHas("students", function (Builder $students) {
                    $students->where("id", principal()->getId());
                });
            });
        }
    }
}
