<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkFormsStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'departments' => DepartmentWorkFormsStatisticResource::collection($this->departments),
        ];
    }
}