<?php

namespace App\Http\Resources\Messages;

use App\Http\Resources\Employees\UserProResource;
use App\Http\Resources\Employees\UserResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class MessageReceiverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_seen' => $this->is_seen,
            'seen_date' => $this->seen_date,
            'is_deleted' => $this->is_deleted,
            'user' => new UserProResource($this->user),
//            'message' => $this->message,
        ];
    }
}
