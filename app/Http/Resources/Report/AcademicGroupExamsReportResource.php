<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicGroupExamsReportResource extends JsonResource
{
    public function toArray($request)
    {
        return
            [
                'id'                => $this->id,
                'employee'          => optional(optional($this->exam)->employee)->name,
                'subject'           => optional(optional($this->exam)->subject)->translate('name') ?? $this->exam?->subject?->name,
                'name'              => optional($this->exam)->name,
                'academic_group'    => optional($this->academic_group)->name,
                'academic_year'     => optional(optional($this->exam)->academic_year)->name,
                'duration'          => optional($this->exam)->duration,
                'datetime_start'    => $this->datetime_start,
                'datetime_end'      => $this->datetime_end,
            ];
    }
}
