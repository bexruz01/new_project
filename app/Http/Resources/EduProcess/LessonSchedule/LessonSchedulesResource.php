<?php

namespace App\Http\Resources\EduProcess\LessonSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonSchedulesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'edu_plan' => optional(optional($this->semester)->edu_plan)->name,
            'academic_year' => optional(optional($this->semester)->academic_year)->name,
            'semester' => optional($this->semester)->semester,
            'academic_group' => optional($this->academic_group)->name,
            'week_count' => $this->week_count,
            'week_list' => WeeksResource::collection($this->lesson_schedule_topics),
        ];
    }
}