<?php

namespace App\Http\Resources\Messages;

use App\Http\Resources\Employees\UserProResource;
use App\Http\Resources\Employees\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'view_count' => $this->view_count,
            'theme' => $this->theme,
            'message' => $this->message,
            'sender' => new UserProResource($this->sender),
            'status' =>$this->message_status->name,
            'receivers'=>MessageReceiverResource::collection($this->receivers)
        ];
    }
}
