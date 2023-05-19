<?php

namespace App\Http\Resources\EduProcess\EduPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class CurriculumEduProcessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'credit' => $this->credit,
            'total_load' => $this->total_load,
            'audiance_hours' => $this->audianceHours(),
            'exam_types' => $this->examTypes(),
        ];
    }

    protected function audianceHours()
    {
        $list = [];
        foreach ($this->audiance_hours as $data) {
            $list[] = [
                'value' => $data->value,
                'name' => optional($data->lesson_activity)->name,
                'type' => optional($data->lesson_activity)->type,
            ];
        }
        return $list;
    }

    protected function examTypes()
    {
        $list = [];
        foreach ($this->exam_types as $data) {
            $list[] = [
                'value' => $data->value,
                'name' => optional($data->exam_type)->name,
                'type' => optional($data->exam_type)->type,
            ];
        }
        return $list;
    }
}