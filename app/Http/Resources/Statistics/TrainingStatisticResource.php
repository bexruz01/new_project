<?php

namespace App\Http\Resources\Statistics;

use App\Models\Lesson\LessonActivity;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $lesson_types = LessonActivity::all();
        $list = [];

        foreach ($lesson_types as $type)
            $list[] = $this->getLessonHour($type);

        return [
            'subject' => $this->subject?->name,
            'list' => $list,
        ];
    }

    protected function getLessonHour($type)
    {
        $hour = 0;
        $done_hour = 0;
        foreach ($this->curriculum_audiance_hourses as $item) {
            if ($type->type == $item->lesson_activity?->type)
                $hour += $item->value;
        }

        foreach ($this->lesson_schedule_topics as $item) {
            if ($type->type == $item->lesson_activity?->type)
                $done_hour += $item->value;
        }

        return [
            'type' => $type->type,
            'hour' => $hour,
            'done_hour' => $done_hour,
            'relic_hour' => $hour - $done_hour,
        ];
    }
}