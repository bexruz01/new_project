<?php

namespace App\Http\Resources\Statistics;

use App\Models\Education\Position;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentPositionsStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $list = Position::all();
        $data = [];
        foreach ($list as $item) {
            $male = $this->getCountMale($item->id);
            $female = $this->getCountFemale($item->id);
            $data[] = [
                'academic_degree' => $item->name,
                'male_count' => $male,
                'female_count' => $female,
                'all_count' => $male + $female,
            ];
        }
        return [
            'name' => $this->name,
            'degrees' => $data,
        ];
    }

    public function getCountMale($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'male' and optional($data->work_contract)->position_id == $id;
        })->count();
    }

    public function getCountFemale($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'female' and optional($data->work_contract)->position == $id;
        })->count();
    }
}