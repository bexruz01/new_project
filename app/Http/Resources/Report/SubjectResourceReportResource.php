<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResourceReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'topics_count' => $this->subject_topics_count,
            'resource_count' => $this->resourceCount(),
        ];
    }

    public function resourceCount()
    {
        $count = 0;
        if ($this->subject_topics)
            foreach ($this->subject_topics as $topic)
                $count += $topic->subject_topic_resources_count;
        return $count;
    }
}