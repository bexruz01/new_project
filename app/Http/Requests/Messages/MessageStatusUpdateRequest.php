<?php

namespace App\Http\Requests\Messages;

use App\Models\Messages\Message;
use App\Models\Messages\MessageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageStatusUpdateRequest extends FormRequest
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
        $id = request()->route()->parameter('id');
        $message  = Message::findOrFail($id);
        return [
            'theme' => 'required|string',
            'message' => 'required|string',
            'users.*'=>'required|numeric|exists:users,id',
            'users'=>'required',
            "status_id"=>'required|numeric|exists:message_status,id',
            'id'=>Rule::requiredIf($message->status_id!=MessageStatus::statusID('draft')),
        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'This message has been sent',
        ];
    }
}
