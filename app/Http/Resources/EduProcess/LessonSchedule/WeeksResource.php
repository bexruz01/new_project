<?php

namespace App\Http\Resources\EduProcess\LessonSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class WeeksResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'position' => optional($this->week)->position,
            'lessons_count' => $this->count,
        ];
    }
}