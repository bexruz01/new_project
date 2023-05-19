<?php

namespace App\Filters\EduProcess;

use App\Filters\QueryFilter;

class EduPlanEduProcessFilter extends QueryFilter
{

    public function text($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('name', 'ilike', '%' . $data . '%');
        });
    }

    public function faculty_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('faculty_id', $data);
        });
    }

    public function edu_form_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('edu_form_id', $data);
        });
    }
    public function edu_type_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('specialty', function ($query) use ($data) {
                $query->whereHas('edu_type', function ($query) use ($data) {
                    $query->where('id', $data);
                });
            });
        });
    }
}