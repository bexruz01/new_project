<?php

namespace App\Http\Resources\Statistics\GeneralStudent;

use App\Models\Additional\Reference;
use App\Models\Additional\Specialty;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSpecialtyGeneralStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $types = Reference::where('table_name', 'payment-types')->get();
        $specialties = Specialty::all();
        $list = [];
        foreach ($specialties as $specialty) {
            $list[] = $this->getCountStudent($specialty, $types);
        }
        return $list;
    }

    public function getCountStudent($data, $types)
    {
        $list = [];
        $full_male = 0;
        $full_female = 0;
        foreach ($types as $type) {
            $male = 0;
            $female = 0;
            foreach ($this['list'] as $item) {
                if ($item->specialty_id == $data->id and $item->payment_type_id == $type->id) {
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
            'specialty' => $data->gov_specialty?->name,
            'list' => $list,
        ];
    }
}