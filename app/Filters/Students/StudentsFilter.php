<?php

namespace App\Filters\Students;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class StudentsFilter extends QueryFilter
{

    public function text($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->when($data, function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where(
                        DB::raw("concat(surname,' ',name,' ',last_name)"),
                        'ilike',
                        '%' . $data . '%'
                    )
                        ->orWhere('passport', 'ilike', '%' . $data . '%');
                });
            });
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


    public function payment_type_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('payment_type_id', $data);
        });
    }


    public function live_place_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('live_place_id', $data);
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


    public function edu_plan_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('academic_group', function ($query) use ($data) {
                $query->where('edu_plan_id',  $data);
            });
        });
    }


    /** Semester idisi bo'yicha filter */
    public function semester_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('semester_id', $data);
        });
    }

    /** Semester raqami bo'yicha filter */
    public function semester($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->whereHas('semester', function ($query) use ($data) {
                $query->where('semester', $data);
            });
        });
    }

    public function academic_group_id($data)
    {
        return $this->builder->when($data, function ($query) use ($data) {
            $query->where('academic_group_id', $data);
        });
    }


    // public function academic_year_id($data)
    // {
    //     return $this->builder->when($data, function ($query) use ($data) {
    //         $query->withWhereHas('semester', function ($query) use ($data) {
    //             $query->where('academic_year_id', $data);
    //         });
    //     });
    // }
}