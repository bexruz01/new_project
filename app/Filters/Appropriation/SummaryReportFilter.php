<?php

namespace App\Filters\Appropriation;

use App\Filters\QueryFilter;

class SummaryReportFilter extends QueryFilter
{

    public function edu_plan_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('academic_group', function ($query) use ($data) {
                $query->where('edu_plan_id', $data);
            });
        });
    }

    public function academic_year_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('semester', function ($query) use ($data) {
                $query->where('academic_year_id', $data);
            });
        });
    }

    public function semester_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('semester_id', $data);
        });
    }

    public function academic_group_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('academic_group_id', $data);
        });
    }
}