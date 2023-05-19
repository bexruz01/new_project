<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveTeachersReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => optional($this->teacher)->full_name,
            'faculty' => optional(optional(optional(optional($this->teacher)->work_contract)->department)->faculty)->name,
            'department' => optional(optional(optional($this->teacher)->work_contract)->department)->name,
            'ip' => $this->ip,
            'message' => $this->text,
            'date' => formatDateTime($this->created_at),
        ];
    }
}