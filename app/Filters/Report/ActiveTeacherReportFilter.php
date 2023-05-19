<?php

namespace App\Filters\Report;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class ActiveTeacherReportFilter extends QueryFilter
{

    public function text($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->when($data, function ($query) use ($data) {
                $query->where(DB::raw("concat(surname,' ',name,' ',patronymic)"), 'ilike', '%' . $data . '%');
            });
        });
    }

    public function department_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('work_contract', function ($query) use ($data) {
                $query->where('department_id', $data);
            });
        });
    }


    public function faculty_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('work_contract', function ($query) use ($data) {
                $query->whereHas('department', function ($query) use ($data) {
                    $query->where('department_id', $data);
                });
            });
        });
    }
}