<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'department' => $this->name,
            'department_ball' => $this->getBall(),
        ];
    }

    public function getBall()
    {
        $ball = 0;
        foreach ($this->employees as $employee)
            $ball += $employee->ball;
        return $ball ?? 0;
    }
}