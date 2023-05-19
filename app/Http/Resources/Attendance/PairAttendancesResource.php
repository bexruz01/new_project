<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class PairAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'position' => optional($this->pair)->position,
            'time_start' => optional($this->pair)->time_start,
            'pair_end' => optional($this->pair)->time_end,
            'status' => optional($this->pair)->status,
            'count_topic' => $this->count,
        ];
    }
}