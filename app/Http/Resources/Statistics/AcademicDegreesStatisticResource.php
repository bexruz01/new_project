<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicDegreesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'departments' => DepartmentAcademicDegreesStatisticResource::collection($this->departments),
        ];
    }
}