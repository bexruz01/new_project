<?php

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Attendance\Subject\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'subjects' => SubjectResource::collection($this->subjects ?? []),
            'students' => $this->studentAttendance() ?? [],
        ];
    }

    public function studentAttendance()
    {
        $list = [];
        foreach ($this->students ?? [] as $student)
            $list[] = $this->attendaceCount($student);
        return $list;
    }

    public function attendaceCount($student)
    {
        $list = [];
        foreach ($this->subjects as $subject) {
            $caused = 0;
            $uncaused = 0;
            foreach ($student->student_attendances as $attendance)
                if ($attendance->lesson_schedule_topic?->subject_id == $subject->id)
                    $attendance->status_id ? $caused++ : $uncaused++;
            $list[] = [
                'id' => $subject->id,
                'subject' => $subject->name,
                'caused' => $caused,
                'uncaused' => $uncaused,
            ];
        }
        return [
            'student' => $student->full_name,
            'subjects' => $list,
        ];
    }
}