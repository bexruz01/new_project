<?php

namespace App\Repository\SelectData;

use App\Models\Academic\AcademicTraining;
use Closure;

class AcademicTrainingRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return $closure(AcademicTraining::query())
                    ->get();
    }

}


