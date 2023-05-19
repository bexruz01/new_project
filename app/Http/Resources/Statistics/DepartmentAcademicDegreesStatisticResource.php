<?php

namespace App\Http\Resources\Statistics;

use App\Models\Academic\AcademicDegree;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentAcademicDegreesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $degrees = AcademicDegree::all();
        $data = [];
        foreach ($degrees as $degree) {
            $male = $this->getCountMaleDegree($degree->id);
            $female = $this->getCountFemaleDegree($degree->id);
            $data[] = [
                'academic_degree' => $degree->name,
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

    public function getCountMaleDegree($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'male' and $data->academic_degree_id == $id;
        })->count();
    }

    public function getCountFemaleDegree($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'female' and $data->academic_degree_id == $id;
        })->count();
    }
}