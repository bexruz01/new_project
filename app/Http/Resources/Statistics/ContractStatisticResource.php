<?php

namespace App\Http\Resources\Statistics;

use App\Models\Additional\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [];
        $edu_forms = Reference::where('table_name', 'edu-forms')
            ->where('status', true)->get();
        foreach ($edu_forms as $edu_form)
            $result[] = [
                'id' => $edu_form->id,
                'edu_form' => $edu_form->name,
                'courses' => $this->sortStudent($edu_form->id),
            ];
        return [
            'faculty' => $this->name,
            'list' => $result,
        ];
    }

    public function sortStudent($id)
    {
        $list = [];
        for ($i = 1; $i <= 5; $i++)
            $list[] = $this->countStudent($id, $i);
        return $list;
    }

    public function countStudent($id, $course)
    {
        $count = 0;
        $contract = 0;
        foreach ($this->students as $student) {
            if ($student->semester?->course == $course and $student->academic_group?->edu_plan?->edu_form_id == $id) {
                if ($student->student_contract?->status)
                    $contract++;
                $count++;
            }
        }
        return [
            'course' => $course,
            'student_count' => $count,
            'contract_count' => $contract,
        ];
    }
}