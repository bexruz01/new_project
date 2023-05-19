<?php

namespace App\Http\Resources\Messages;

use App\Http\Resources\Employees\UserProResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageReceiverProResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'is_seen' => $this->is_seen,
            'seen_date' => $this->seen_date,
            'is_deleted' => $this->is_deleted,
//            'user' => new UserProResource($this->user),
            'message' => new MessageProResource($this->message),
        ];
    }
}
