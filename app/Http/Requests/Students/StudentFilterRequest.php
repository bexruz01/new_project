<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class StudentFilterRequest extends FormRequest
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
            'edu_type_id' => ['integer', 'exists:references,id,table_name,edu-types'],
            'payment_form_id' => ['integer', 'exists:references,id,table_name,payment-types'],
            'live_place_id' => ['integer', 'exists:references,id,table_name,live-places'],
            'edu_form_id' => ['integer', 'exists:references,id,table_name,edu-forms'],
            'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            'semester_id' => ['integer', 'exists:semesters,id'],
            'group_id' => ['integer', 'exists:academic_groups,id'],
        ];
    }
}