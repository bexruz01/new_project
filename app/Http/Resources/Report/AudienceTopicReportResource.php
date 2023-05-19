<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class AudienceTopicReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'audience' => $this->audience?->name,
            'subject' => $this->subject?->name,
            'type' => $this->lesson_activity?->name,
            'employee' => $this->employee?->full_name,
            'academic_group' => $this->lesson_schedule?->academic_group?->name,
            'pair' => $this->pair?->name,
        ];
    }
}