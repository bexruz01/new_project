<?php

namespace App\Repository\SelectData;

use App\Models\Education\Subject;
use Closure;

class SubjectRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(Subject::query())
                    ->where('status',true)
                        ->get();
    }

}


