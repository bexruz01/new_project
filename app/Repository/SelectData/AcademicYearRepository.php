<?php

namespace App\Repository\SelectData;

use App\Models\Academic\AcademicYear;
use Closure;

class AcademicYearRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(AcademicYear::query())
                    ->where('status',true)
                        ->get();
    }

}


