<?php

namespace App\Http\Resources\Statistics;

use App\Models\Academic\AcademicTitle;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentAcademicTitlesStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $titles = AcademicTitle::all();
        $data = [];
        foreach ($titles as $title) {
            $male = $this->getCountMaleTitle($title->id);
            $female = $this->getCountFemaleTitle($title->id);
            $data[] = [
                'academic_degree' => $title->name,
                'male_count' => $male,
                'female_count' => $female,
                'all_count' => $male + $female,
            ];
        }
        return [
            'name' => $this->name ?? '',
            'degrees' => $data,
        ];
    }

    public function getCountMaleTitle($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'male' and $data->academic_title_id == $id;
        })->count();
    }

    public function getCountFemaleTitle($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'female' and $data->academic_title_id == $id;
        })->count();
    }
}