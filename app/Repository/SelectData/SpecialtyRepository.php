<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Specialty;
use Closure;

class SpecialtyRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getSpecialtyList(Closure $closure)
    {
        return $closure(Specialty::query())
            ->get();
    }
}