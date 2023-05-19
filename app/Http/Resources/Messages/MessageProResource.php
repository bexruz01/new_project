<?php

namespace App\Http\Resources\Messages;

use App\Http\Resources\Employees\UserProResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageProResource extends JsonResource
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
            'status' =>$this->message_status->name,
            'is_seen' =>$this->sender_id==auth()->id()?true:$this->receivers->where('user_id',auth()->id())->first()->is_seen,
            'seen_date' =>$this->sender_id==auth()->id()?$this->created_at:$this->receivers->where('user_id',auth()->id())->first()->seen_date,
            'sender' => new UserProResource($this->sender),
            'old_status'=>$this->old_status

        ];
    }
}
