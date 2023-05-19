<?php

namespace App\Http\Resources\Statistics\GeneralStudent;

use App\Models\Additional\Nation;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentNationGeneralStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $nationals = $result['nations'] = Nation::select('id', 'name')->get();
        $list = [];
        foreach ($nationals as $nation) {
            $list[] = $this->getCountStudent($nation);
        }
        return $list;
    }

    public function getCountStudent($data)
    {
        $list = [];
        $full_male = 0;
        $full_female = 0;
        for ($course = 1; $course <= 5; $course++) {
            $male = 0;
            $female = 0;
            foreach ($this['list'] as $item) {
                if ($item->nation_id   == $data->id and $item->course == $course) {
                    if ($item->gender == 'male')
                        $male++;
                    else
                    if ($item->gender == 'female')
                        $female++;
                }
            }
            $full_male += $male;
            $full_female += $female;
            $list[] = [
                'course' => $course,
                'male' => $male,
                'female' => $female,
                'count' => $male + $female,
            ];
        }
        $list[] = [
            'all' => 'all_count',
            'male' => $full_male,
            'female' => $full_female,
            'count' => $full_male + $full_female,
        ];
        return [
            'natoin' => $data->name,
            'list' => $list,
        ];
    }
}