<?php

namespace App\Http\Resources\EduProcess\EduPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class EduPlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'edu_plan' => $this->name,
            'faculty' => $this->faculty?->name,
            'specialty' => $this->specialty?->gov_specialty?->name,
            'edu_type' => optional(optional($this->specialty)->edu_type)->name,
            'edu_form' => optional($this->edu_form)->name,
            'rating_system' => optional($this->rating_system)->name,
            'academic_groups' => AcademicGroupsResource::collection($this->academic_groups),
            'semesters' => $this->semesters(),
        ];
    }

    public function semesters()
    {
        $semesters = [];
        foreach ($this->semesters as $semester) {
            $semesters[] = [
                'semester_id' => $semester->id,
                'semester' => $semester->semester,
                'subjects' => $this->subjects($semester),
            ];
        }
        return $semesters;
    }

    public function subjects($semester)
    {
        $subjects = [];
        foreach ($semester->curriculums as $curriculum) {
            $credit = $curriculum->credit;
            $total_load = $curriculum->total_load;
            foreach ($curriculum->subjects as $subject) {
                $subjects[] = [
                    'subject' => $subject->name,
                    'type' => $subject->subject_type?->name,
                    'total_load' => $total_load,
                    'credit' => $credit,
                ];
            }
        }
        return $subjects;
    }
}