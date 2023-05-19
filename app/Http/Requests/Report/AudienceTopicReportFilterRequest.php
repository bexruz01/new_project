<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class AudienceTopicReportFilterRequest extends FormRequest
{

    public static function filterValidate()
    {
        return [
            'week_id' => ['integer', 'exists:weeks,id'],
            'date' => ['required'],
            'audience_id' => ['required', 'integer', 'exists:audiences,id'],
            'pair_id' => ['required', 'integer', 'exists:pairs,id'],
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