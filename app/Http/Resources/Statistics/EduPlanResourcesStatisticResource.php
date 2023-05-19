<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class EduPlanResourcesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'edu_plan' => $this->name,
            'faculty' => optional($this->faculty)->name,
            'count' => $this->countResource($this->curriculums),
        ];
    }

    public function countResource($data)
    {
        $count = 0;
        foreach ($data as $curriculum)
            foreach ($curriculum->curriculum_subjects as $csubject)
                if ($csubject->subject)
                    $count += $csubject->subject->subject_topic_resources_count;
        return $count;
    }
}