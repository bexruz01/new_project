<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentProResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'status' => $this->status,
            'type' => $this->type,
            'department_id' => $this->department_id,
            'department_type' => new DepartmentTypeResource($this->department_type)
        ];
    }
}
