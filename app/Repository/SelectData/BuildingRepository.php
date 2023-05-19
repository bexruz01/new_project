<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Building;
use Closure;

class BuildingRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(Building::query())
                    ->where('status',true)
                        ->get();
    }

}


