<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ExamReportFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'academic_year_id' => ['integer', 'exists:academic_years,id'],
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