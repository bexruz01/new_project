<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicTitlesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'departments' => DepartmentAcademicTitlesStatisticResource::collection($this->departments),
        ];
    }
}