<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class AudienceReportFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'week_id' => ['required', 'integer', 'exists:weeks,id'],
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'building_id' => ['integer', 'exists:buildings,id'],
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