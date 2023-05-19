<?php

namespace App\Services\Messages;

use App\Services\Messages\Contracts\MessageServiceInterface;
use App\Models\Messages\MessageReceiver;
use App\Models\Messages\MessageStatus;
use App\Models\Messages\Message;
use Illuminate\Http\Request;

class MessageService implements MessageServiceInterface
{
    protected $message;

    public function __construct()
    {
        $this->message = Message::class;
    }

    public function filter(Request $request)
    {
        $collection = Message::with(['receivers', 'message_status'])
            ->where(function ($query) use ($request) {
                if (in_array($request->get('status', 'none'), ['draft', 'completed'])) {
                    $query->where('sender_id', auth()->id())
                        ->whereHas('message_status', function ($query) use ($request) {
                            $query->where('message_status.key', $request->get('status'));
                        });
                } elseif ($request->get('status', 'none') == 'received') {
                    $query->received();
                } elseif ($request->get('status', 'none') == 'deleted') {
                    $query->deleted();
                } elseif ($request->get('status', 'none') == 'unread') {
                    $query->unread();
                } else {
                    $query->completed()
                        ->orWhere(function ($query) use ($request) {
                            $query->received();
                        });
                }
            })->where(function ($query) use ($request) {
                $query->where('message', 'like', '%' . $request->get('search', '') . '%')
                    ->Orwhere('theme', 'like', '%' . $request->get('search', '') . '%');
            })->paginate($request->get('per_page', 10));
        return $collection;
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'status_id' => $request->status_id,
            'message' => $request->message,
            'theme' => $request->theme,
            'view_count' => 0,
        ]);
        foreach ($request->users as $user) {
            MessageReceiver::create([
                'user_id' => $user,
                'message_id' => $message->id,
                'is_seen' => false,
                'is_deleted' => false,
            ]);
        }
        return $message;
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update([
            'status_id' => $request->status_id,
            'message' => $request->message,
            'theme' => $request->theme,
        ]);
        foreach ($message->receivers as $receiver) {
            MessageReceiver::findOrFail($receiver->id)->delete();
        }
        foreach ($request->users as $user) {
            MessageReceiver::create([
                'user_id' => $user,
                'message_id' => $message->id,
                'is_seen' => false,
                'is_deleted' => false,
            ]);
        }
        return $message;
    }

    public function show($id)
    {
        $message = Message::withoutTrashed()->findOrFail($id);
        if (in_array(auth()->id(), $message->receivers->pluck('user_id')->toArray())) {
            $receiver = MessageReceiver::where('user_id', auth()->id())->where('message_id', $message->id)->first();
            if (!$receiver->is_seen) {
                $message->view_count += 1;
                $receiver->is_seen = true;
                $receiver->seen_date = date("Y-m-d H:m:s");
                $receiver->save();
                $message->save();
            }
        }
        return $message;
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);
        if ($message->sender_id == auth()->id()) {
            if ($message->status_id == MessageStatus::statusID('deleted')) {
                $message->status_id = MessageStatus::statusID('force-deleted');
            } else {
                $message->update([
                    'status_id' => MessageStatus::statusID('deleted'),
                    'old_status' => $message->message_status->key
                ]);
            }
        } else {
            $receiver = MessageReceiver::where('message_id', $id)->where('user_id', auth()->id())->first();
            if ($receiver->is_deleted) {
                MessageReceiver::destroy($receiver->id);
            } else {
                $receiver->update([
                    'is_deleted' => true
                ]);
            }
        }
        return __("auth.failed A message deleted");
    }

    public function delete_list(Request $request)
    {
        foreach ($request->ids as $id) {
            $message = Message::findOrFail($id);

            if ($message->sender_id == auth()->id()) {
                if ($message->status_id == MessageStatus::statusID('deleted')) {
                    $message->status_id = MessageStatus::statusID('force-deleted');
                } else {
                    $message->update([
                        'status_id' => MessageStatus::statusID('deleted'),
                        'old_status' => $message->message_status->key
                    ]);
                }
            } else {
                $receiver = MessageReceiver::where('message_id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($receiver->is_deleted) {
                    MessageReceiver::destroy($receiver->id);
                } else {
                    $receiver->update([
                        'is_deleted' => true
                    ]);
                }
                // return ['message' => 'not good'];
            }
        }

        return ['message' => 'success'];
    }

    public function restore($id)
    {
        $message = Message::findOrFail($id);
        if ($message->sender_id == auth()->id()) {
            if ($message->status_id == MessageStatus::statusID('deleted')) {
                $message->update([
                    'status_id' => MessageStatus::statusID($message->old_status),
                    'old_status' => 'null'
                ]);
            }
        } else {
            $receiver = MessageReceiver::where('message_id', $id)->where('user_id', auth()->id())->first();
            $receiver->update([
                'is_deleted' => false
            ]);
        }
        return __("auth.failed The message has been restored");
    }
}