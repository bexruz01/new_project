<?php

namespace App\Http\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class ResourceStatisticFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'faculty_id' => ['required', 'numeric', 'exists:departments,id,type,faculty'],
            'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            'semester_id' => ['integer', 'exists:semesters,id'],
            'subject_id' => ['integer', 'exists:subjects,id'],
            // 'exam_type_id' => ['required', 'numeric', 'exists:exam_types,id'],
            'language_id' => ['integer', 'exists:languages,id']
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