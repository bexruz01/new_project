<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'theme' => 'required|string',
            'message' => 'required|string',
            'users.*' => 'required|numeric|exists:users,id|not_in:' . auth()->id(),
            'users' => 'required',
//            "status_id"=>'required|numeric|exists:message_status,id'
        ];
    }
}
