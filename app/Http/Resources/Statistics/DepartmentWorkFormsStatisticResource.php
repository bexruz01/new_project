<?php

namespace App\Http\Resources\Statistics;

use App\Models\Additional\WorkForm;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentWorkFormsStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $titles = WorkForm::all();
        $data = [];
        foreach ($titles as $title) {
            $male = $this->getCountMale($title->id);
            $female = $this->getCountFemale($title->id);
            $data[] = [
                'academic_degree'   => $title->name,
                'male_count'        => $male,
                'female_count'      => $female,
                'all_count'         => $male + $female,
            ];
        }
        return [
            'name'      => $this->name,
            'degrees'   => $data,
        ];
    }

    public function getCountMale($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'male' and optional($data->work_contract)->work_form_id == $id;
        })->count();
    }

    public function getCountFemale($id)
    {
        return $this->employees->filter(function ($data) use ($id) {
            return $data->gender == 'female' and optional($data->work_contract)->work_form_id == $id;
        })->count();
    }
}
