<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->translate('name'),
            'code' => $this->code,
            'status' => $this->status,
            'type' => $this->type,
            'department_type' => new DepartmentTypeResource($this->department_type),
            'department_id' => $this->department_id,
        ];
    }
}
