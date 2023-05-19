<?php

namespace App\Http\Resources\EduProcess\EduPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicGroupsResource extends JsonResource
{
    public function toArray($request)
    {
        return ['name' => $this->name];
    }
}