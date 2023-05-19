<?php

namespace App\Http\Requests\Appropriation;

use Illuminate\Foundation\Http\FormRequest;

class SummaryReportAppropriationFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'edu_plan_id' => ['required', 'integer', 'exists:edu_plans,id'],
            'academic_year_id' => ['required', 'integer', 'exists:academic_years,id'],
            'semester_id' => ['required', 'integer', 'exists:semesters,id'],
            'academic_group_id' => ['required', 'integer', 'exists:academic_groups,id'],
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