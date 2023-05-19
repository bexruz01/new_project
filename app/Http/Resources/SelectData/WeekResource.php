<?php

namespace App\Http\Resources\SelectData;

use Illuminate\Http\Resources\Json\JsonResource;

class WeekResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date_start . ' - ' . $this->date_end,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ];
    }
}