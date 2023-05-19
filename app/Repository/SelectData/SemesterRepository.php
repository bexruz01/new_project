<?php

namespace App\Repository\SelectData;

use App\Models\Education\Semester;
use Closure;

class SemesterRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(Semester::query())
                    ->where('status',true)
                        ->get();
    }

}


