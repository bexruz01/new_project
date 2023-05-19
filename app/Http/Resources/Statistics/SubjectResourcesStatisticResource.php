<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResourcesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'edu_plan' => $this->curriculum?->edu_plan?->name,
            // 'faculty' => optional(optional($this->department)->faculty)->name,
            'subject' => $this->subject?->name,
            'semester' => $this->curriculum?->semester?->semester,
            'count' => $this->resourceCunt(),
        ];
    }

    public function resourceCunt()
    {
        $count = 0;
        foreach ($this->subject?->subject_topics as $topic)
            $count += $topic->subject_topic_resources->count();
        return $count;
    }
}