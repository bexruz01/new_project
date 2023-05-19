<?php

namespace App\Repository\SelectData;

use App\Models\Academic\AcademicGroup;
use Closure;

class AcademicGroupRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(AcademicGroup::query())
                    ->where('status',true)
                        ->get();
    }

}


