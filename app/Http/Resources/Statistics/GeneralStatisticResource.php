<?php

namespace App\Http\Resources\Statistics;

use App\Models\Additional\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this['faculty']?->name,
            'specialty' => $this['specialty']?->gov_specialty?->name,
            'students' => $this->countInCourse(),
        ];
    }

    protected function  countInCourse()
    {
        $list = [];
        for ($i = 1; $i <= 5; $i++) {
            $list['course' . $i] = $this->countInPaymentType($i);
        }
        return $list;
    }

    protected function  countInPaymentType($course)
    {
        $list = [];
        $paymentTypes = Reference::where('table_name', 'payment-types')->where('status', true)->get();
        // $paymentTypes = ['grand', 'contranct'];
        foreach ($paymentTypes as $type) {
            $list[] = $this->studentCount($course, $type->id, $type->name);
        }
        return $list;
    }

    public function studentCount($course, $id, $name)
    {
        $countMale = 0;
        $countFemale = 0;
        foreach ($this['students'] as $student)
            if ($student->semester?->course == $course and $student->payment_type_id == $id)
                if ($student->gender = 'male')
                    $countMale++;
                else
                    $countFemale++;
        return [
            'name' => $name,
            'count_male' => $countMale,
            'count_female' => $countFemale,
        ];
    }
}