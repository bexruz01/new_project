<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'full_name' => optional($this->student)->full_name,
            'specialty' => optional(optional(optional($this->student)->specialty)->gov_specialty)->name,
            'edu_type' => optional(optional(optional($this->student)->specialty)->edu_type)->name,
            'academic_group' => optional(optional($this->student)->academic_group)->name,
            'semester' => optional(optional($this->student)->semester)->semester,
            'because_of' => $this->because_of,
            'not_because_of' => $this->not_because_of,
            'total_nb' => $this->total_nb,
        ];
    }
}
