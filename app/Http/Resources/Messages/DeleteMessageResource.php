<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "theme" => $this->theme,
            "message" => $this->message,
            "sender_id" => $this->sender_id,
            "status_id" => $this->status_id,
            "view_count" => $this->view_count,
            "old_status" => $this->old_status,
            "receivers" => ReceiverMessageResource::collection($this->receivers),
            "sender" => $this->sender,
        ];
    }
}