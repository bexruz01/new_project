<?php

namespace App\Http\Resources\SelectData;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}