<?php

namespace App\Http\Resources\EduProcess\LessonSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'week_id' => $this->week_id,
            'audience' => optional($this->audience)->name,
            'employee' => optional($this->employee)->full_name,
            'lesson_activity' => optional($this->lesson_activity)->name,
            'topic_done' => $this->topic_done,
            'additional' => $this->additional_text,
            'subject' => optional($this->subject)->name,
            'pair'=> new PairSomeResource($this->pair)
        ];
    }
}