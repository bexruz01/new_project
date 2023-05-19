<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonScheduleTopicEmployeeReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'pair_id' => $this->pair_id,
            'employee_id' => $this->employee_id,
            'pair' => optional($this->pair)->name,
            'count' => $this->count,
        ];
    }
}