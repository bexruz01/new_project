<?php

namespace App\Services\Messages;

use App\Services\Messages\Contracts\MessageReceiverServiceInterface;
use App\Models\Messages\MessageReceiver;
use App\Models\Messages\MessageStatus;
use App\Models\Messages\Message;
use Illuminate\Http\Request;

class MessageReceiverService implements MessageReceiverServiceInterface
{
    protected $message;

    public function __construct()
    {
        $this->message = MessageReceiver::class;
    }

    public function filter(Request $request)
    {
        $result = $this->message::all();
        return $result;
    }

    public function store(Request $request)
    {
        foreach ($request->users as $user) {
            $message = $this->message::create([
                'user_id' => $user,
                'message_id' => $request->message_id,
                'is_seen' => false,
                'is_deleted' => false,
            ]);
        }
        $messages = $this->message::where('message_id', $request->message_id)->get();
        Message::findOrFail($request->message_id)->update([
            'message_status_id' => MessageStatus::statusID('sent'),
        ]);
        return $messages;
    }

    public function search(Request $request)
    {
    }

    public function update(Request $request, $id)
    {

        // return $about;
    }

    public function delete($id)
    {
        return $this->message::destroy($id);
    }
}