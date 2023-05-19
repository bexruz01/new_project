<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ActiveStudentReportFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'edu_type_id' => ['integer', 'exists:references,id,table_name,edu-types'],
            'edu_form_id' => ['integer', 'exists:references,id,table_name,edu-forms'],
            'academic_group_id' => ['integer', 'exists:academic_groups,id'],
            'course' => ['integer'],
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