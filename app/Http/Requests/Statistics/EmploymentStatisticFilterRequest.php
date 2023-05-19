<?php

namespace App\Http\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentStatisticFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'faculty_id' => ['required', 'numeric', 'exists:departments,id,type,faculty'],
            'academic_year_id' => ['required', 'numeric', 'exists:academic_years,id'],
            'edu_type_id' => ['required', 'integer', 'exists:references,id,table_name,edu-types'],
            'semester_id' => ['integer', 'exists:semesters,id'],
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