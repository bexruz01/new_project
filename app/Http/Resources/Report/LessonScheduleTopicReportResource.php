<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonScheduleTopicReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'pair_id' => $this->pair_id,
            'audience_id' => $this->audience_id,
            'pair' => optional($this->pair)->name,
            'count' => $this->count,
        ];
    }
}