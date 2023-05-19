<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionsStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'departments' => DepartmentPositionsStatisticResource::collection($this->departments),
        ];
    }
}