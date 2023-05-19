<?php

namespace App\Filters\EduProcess;

use App\Filters\QueryFilter;

class LessonScheduleEduProcessFilter extends QueryFilter
{
    public function text($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('name', 'ilike', '%' . $data . '%');
        });
    }
}