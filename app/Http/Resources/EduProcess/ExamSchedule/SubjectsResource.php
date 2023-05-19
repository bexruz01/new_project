<?php

namespace App\Http\Resources\EduProcess\ExamSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'subject' => optional($this->subject)->name,
            'position' => $this->final_exam_position,
            'count' => $this->count,
        ];
    }
}
