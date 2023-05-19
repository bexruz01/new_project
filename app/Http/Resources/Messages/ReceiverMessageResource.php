<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiverMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "message_id" => $this->message_id,
            "is_seen" => $this->is_seen,
            "seen_date" => $this->seen_date,
            "is_deleted" => $this->is_deleted,
            "student" => $this->student,
            "employee" => new EmployeeMessageResource($this->employee)
        ];
    }
}