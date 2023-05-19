<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class ReportAttendanceFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'edu_type_id' => ['integer', 'exists:references,id,table_name,edu-types'],
            'edu_form_id' => ['integer', 'exists:references,id,table_name,edu-forms'],
            'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            'academic_group_id' => ['integer', 'exists:academic_groups,id'],
            'semester_id' => ['integer', 'exists:semesters,id'],
            'subject_id' => ['integer', 'exists:subjects,id'],
        ];
    }
}