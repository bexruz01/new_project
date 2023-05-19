<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Department;
use Closure;

class DepartmentRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList($type, Closure $closure)
    {
        return $closure(Department::query())->where('type', $type)->get();
    }

}


