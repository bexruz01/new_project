<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Reference;
use Closure;

class ReferenceRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList($table_name, Closure $closure)
    {
        return $closure(Reference::query())->where('table_name', $table_name)->get();
    }

}


