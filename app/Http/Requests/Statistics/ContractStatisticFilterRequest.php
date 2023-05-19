<?php

namespace App\Http\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class ContractStatisticFilterRequest extends FormRequest
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
            'faculty_id' => ['required', 'integer', 'exists:departments,id,type,faculty'],
            'edu_type_id' => ['required', 'integer', 'exists:references,id,table_name,edu-types'],
            'semester_type' => ['required', 'integer', 'exists:references,code,table_name,semester-types'],
            'academic_year_id' => ['required', 'integer', 'exists:academic_years,id'],
            'semester_type_id' => ['integer'],
        ];
    }
}