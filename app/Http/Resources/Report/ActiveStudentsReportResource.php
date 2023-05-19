<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveStudentsReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "full_name" => optional($this->student)->full_name,
            'academic_group' => optional($this->academic_group)->name,
            'faculty' => optional(optional($this->student)->department)->name,
            'specialty_code' => optional(optional($this->specialty)->type)->code,
            'payment_type' => optional($this->payment_type)->name,
            'edu_type' => optional(optional(optional($this->student)->specialty)->edu_type)->name,
            'edu_form' => optional(optional(optional($this->academic_group)->edu_plan)->edu_form)->name,
            'ip' => $this->ip,
            'message' => $this->text,
            'date' => formatDateTime($this->created_at),
        ];
    }
}