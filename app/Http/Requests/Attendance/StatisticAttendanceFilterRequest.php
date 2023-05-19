<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StatisticAttendanceFilterRequest extends FormRequest
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
            'academic_year_id' => ['integer', 'exists:academic_years,id'],
            'semester_type_id' => ['integer'],
            'edu_type_id' => ['integer', 'exists:references,id,table_name,edu-types'],
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'edu_form_id' => ['integer', 'exists:edu_plans,id,table_name,edu-forms'],
        ];
    }
}