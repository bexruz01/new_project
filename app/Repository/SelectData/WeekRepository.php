<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Week;
use Closure;

class WeekRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(Week::query())
            ->get();
    }
}