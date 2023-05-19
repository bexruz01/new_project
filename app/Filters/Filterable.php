<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}
