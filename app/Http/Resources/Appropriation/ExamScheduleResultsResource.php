<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResultsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'full_name' => optional($this->student)->full_name,
            'rating' => $this->rating,
        ];
    }
}