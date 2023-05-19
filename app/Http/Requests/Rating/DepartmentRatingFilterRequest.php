<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRatingFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'academic_year_id' => ['required', 'numeric', 'exists:academic_years,id'],
            'faculty_id' => ['required', 'numeric', 'exists:departments,id,type,faculty'],
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