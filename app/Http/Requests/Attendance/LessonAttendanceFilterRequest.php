<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class LessonAttendanceFilterRequest extends FormRequest
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
            'faculty_id' => ['integer', 'exists:departments,id,type,faculty'],
            'date_start' => ['date'],
            'date_end' => ['date', 'after:date_start'],
            'statistical_id' => ['integer'],
        ];
    }
}