<?php

namespace App\Http\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStatisticFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'academic_year_id' => ['integer', 'exists:academic_years,id'],
            'semester_type' => ['integer', 'exists:references,code,table_name,semester-types'],
            'faculty_id' => ['required', 'integer', 'exists:departments,id,type,faculty'],
            'social_category_id' => ['required', 'integer', 'exists:references,id,table_name,social-categories']
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