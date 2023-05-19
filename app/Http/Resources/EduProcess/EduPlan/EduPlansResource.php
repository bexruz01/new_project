<?php

namespace App\Http\Resources\EduProcess\EduPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class EduPlansResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'edu_plan' => $this->name,
            'specialty_id' => $this->specialty_id,
            'specialty' => optional($this->specialty)->name,
            'faculty' => optional($this->faculty)->name,
            'edu_type' => optional(optional($this->specialty)->edu_type)->name,
            'rating_system' => optional($this->rating_system)->name,
            'count_semester' => $this->count_semester,
            'weeks_count' => $this->weeks_count,
            'subject_count' => $this->countSubject(),
            'academic_groups_count' => $this->academic_groups_count,
        ];
    }

    public function countSubject() {
        $count = 0;
        foreach($this->curriculums as $data)
            $count += optional($data, function($data){
                return $data->subjects_count;
            });
        return $count;
    }
}