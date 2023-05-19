<?php

namespace App\Repository\SelectData;

use App\Models\Education\EduPlan;
use Closure;

class EduPlanRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(EduPlan::query())
                    ->where('status',true)
                        ->get();
    }

}


