<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class AudienceReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'type' => optional($this->audience_type)->name,
            'capacity' => $this->capacity,
            'topics' => LessonScheduleTopicReportResource::collection($this->lesson_schedule_topics),
        ];
    }
}