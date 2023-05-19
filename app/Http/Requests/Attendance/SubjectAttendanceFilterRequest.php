<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class SubjectAttendanceFilterRequest extends FormRequest
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
            'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            'academic_year_id' => ['integer', 'exists:academic_years,id'],
            'semester_id' => ['integer', 'exists:semesters,id'],
            'edu_form_id' => ['integer', 'exists:references,id,table_name,edu-forms'],
            'academic_group_id' => ['required', 'integer', 'exists:academic_groups,id'],
        ];
    }
}