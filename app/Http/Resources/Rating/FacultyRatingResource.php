<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class FacultyRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'ball' => $this->getBall(),
        ];
    }

    public function getBall()
    {
        $ball = 0;
        foreach ($this->departments as $department)
            $ball += $department->employees->pluck('ball')->sum() ?? 0;
        return $ball;
    }
}