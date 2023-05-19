<?php

namespace App\Http\Resources\SelectData;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialtyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->gov_specialty?->name,
            'code' => $this->gov_specialty?->code,
        ];
    }
}