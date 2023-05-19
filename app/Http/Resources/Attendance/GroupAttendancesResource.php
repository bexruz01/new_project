<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lesson_topic_count' => $this->lesson_topic_count,
        ];
    }
}