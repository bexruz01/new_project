<?php

namespace App\Http\Resources\Statistics;

use App\Models\Additional\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSocialCourseStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $code = 1;
        $list = [];
        $edu_forms = Reference::where('table_name', 'edu-forms')->where('status', true)->get();
        foreach ($edu_forms as $edu_form) {
            $list[] = [
                'code' => $code,
                'edu_form' => $edu_form->name,
                'courses' => $this->studentCountEduForm($edu_form->id, $code),
            ];
            $code++;
        }

        return  [
            'faculty' => $this->name,
            'edu_forms' => $list,
        ];
    }

    public function studentCountEduForm($edu_form_id, $code)
    {
        $result = [];
        for ($course = 1; $course <= 5; $course++) {
            $result[] = [
                'code' => $code,
                'course' => $course,
                'count' => $this->studentCountCourse($edu_form_id, $course)
            ];
        }
        return $result;
    }

    public function studentCountCourse($id, $course)
    {
        return $this->students->filter(function ($student) use ($id, $course) {
            return $student->academic_group?->edu_plan?->edu_form_id == $id
                and $student->semester?->course == $course;
        })->count();
    }
}