<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => optional(optional($this->department)->faculty)->name,
            'department' => optional($this->department)->name,
            'subject' => optional($this->subject)->name,
            'edu_plan' => optional(optional($this->curriculum)->edu_plan)->name,
            'edu_type' => optional(optional($this->subject)->edu_type)->name,
            'edu_form' => optional(optional(optional($this->curriculum)->edu_plan)->edu_form)->name,
            'subject_type' => optional(optional($this->subject)->subject_type)->name,
            'semester' => optional(optional($this->curriculum)->semester)->semester,
            'topic_count' => optional($this->subject)->subject_topics_count,
            'resource_count' => optional($this->subject)->subject_topic_resources_count,
            'task_count' => $this->subject_tasks_count,
        ];
    }
}