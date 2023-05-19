<?php

namespace App\Http\Resources\EduProcess\LessonSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class PairSomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
        ];
    }
}