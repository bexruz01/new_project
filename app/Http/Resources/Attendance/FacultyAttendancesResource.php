<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class FacultyAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lesson_count' => $this->academic_group ? $this->sumLessonTopicCount($this->academic_group) : 0,
        ];
    }

    private function sumLessonTopicCount($data)
    {
        $summa = 0;
        foreach ($data as $item)
            $summa += $item->lesson_topic_count;
        return $summa;
    }
}