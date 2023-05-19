<?php

namespace App\Http\Resources\Students;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fio' => $this->full_name,
            'gender' => $this->gender,
            'pinfl' => $this->pinfl,
            'passport' => $this->passport,
            'specialty_code' => optional(optional($this->specialty)->type)->code,
            'payment_type' => optional($this->payment_type)->name,
            'edu_type' => optional(optional($this->specialty)->edu_type)->name,
            'edu_form' => optional(optional(optional($this->academic_group)->edu_plan)->edu_form)->name,
            'academic_year' => optional(optional($this->academic_group)->edu_plan)->academic_year,
            'academic_group' => optional($this->academic_group)->name,
            'semester' => optional($this->semester)->semester,
            'course' => optional($this->semester)->course,
            'region' => optional($this->region)->name,
            'district' => optional($this->district)->name,
            'live_place' => optional($this->live_place)->name,
            'phone' => $this->phone,
        ];
    }
}