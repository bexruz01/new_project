<?php

namespace App\Http\Requests\Appropriation;

use Illuminate\Foundation\Http\FormRequest;

class RatingReportAppropriationFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            'academic_year_id' => ['integer', 'exists:academic_years,id'],
            'semester_id' => ['integer', 'exists:semesters,id'],
            'academic_group_id' => ['integer', 'exists:academic_groups,id'],
            'subject_id' => ['integer', 'exists:subjects,id'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}