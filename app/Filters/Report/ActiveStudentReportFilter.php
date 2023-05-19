<?php

namespace App\Filters\Report;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class ActiveStudentReportFilter extends QueryFilter
{

    public function text($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->when($data, function ($query) use ($data) {
                $query->where(DB::raw("concat(surname,' ',name,' ',last_name)"), 'ilike', '%' . $data . '%')
                    ->orWhere('id', 'ilike', '%' . $data . '%')
                    ->orWhere('pinfl', 'ilike', '%' . $data . '%')
                    ->orWhere('passport', 'ilike', '%' . $data . '%');
            });
        });
    }

    public function faculty_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('faculty_id', $data);
        });
    }

    public function edu_type_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('specialty', function ($query) use ($data) {
                $query->where('edu_type_id', $data);
            });
        });
    }

    public function edu_form_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('academic_group', function ($query) use ($data) {
                $query->whereHas('edu_plan', function ($query) use ($data) {
                    $query->where('edu_form_id', $data);
                });
            });
        });
    }

    public function academic_group_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('academic_group_id', $data);
        });
    }

    public function course($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('semester', function ($query) use ($data) {
                $query->where('course', $data);
            });
        });
    }
}