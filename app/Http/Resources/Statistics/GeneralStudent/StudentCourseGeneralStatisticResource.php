<?php

namespace App\Http\Resources\Statistics\GeneralStudent;

use App\Models\Additional\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseGeneralStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $types = Reference::where('table_name', 'payment-types')->get();
        $list = [];
        for ($i = 1; $i <= 5; $i++) {
            $list[] = $this->getCountStudent($i, $types);
        }
        return $list;
    }

    public function getCountStudent($course, $types)
    {
        $list = [];
        $full_male = 0;
        $full_female = 0;
        foreach ($types as $type) {
            $male = 0;
            $female = 0;
            foreach ($this['list'] as $item) {
                if ($item->course == $course and $item->payment_type_id == $type->id) {
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
                'payment_type_id' => $type->id,
                'payment_type' => $type->name,
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
            'course' => $course,
            'list' => $list,
        ];
    }
}