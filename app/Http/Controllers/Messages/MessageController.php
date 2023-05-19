<?php

namespace App\Http\Controllers\Messages;

use App\Services\Messages\Contracts\MessageServiceInterface;
use App\Http\Requests\Messages\MessageRestoreRequest;
use App\Http\Resources\Messages\MessageProResource;
use App\Http\Resources\Messages\MessageResource;
use App\Http\Requests\Messages\MessageRequest;
use App\Models\Messages\MessageReceiver;
use App\Models\Messages\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Messages\DeleteMessageResource;
use App\Http\Resources\Messages\SendMessageResource;
use App\Models\Messages\Message;
use App\Models\User\Employee;
use App\Models\User\Student;
use Illuminate\Http\Request;
use App\Traits\ApiPaginate;
use App\Traits\ApiResponse;
use Throwable;

class MessageController extends Controller
{
    use ApiResponse, ApiPaginate;

    public function index(Request $request, MessageServiceInterface $messages)
    {
        $collection = $messages->filter($request);
        $result = MessageProResource::collection($collection);
        return $this->success($this->paginate($collection, $result));
    }

    public function receivedMessagesList(Request $request)
    {
        $term = $request->search_string;
        $completedStatusID = MessageStatus::statusID('completed');

        $data = Message::with([
            'sender:id,image,name,surname,patronymic,user_id',
            'receiver:id,is_seen,user_id,message_id'
        ])
            ->when($term, function ($query, $term) {
                $query
                    ->whereRelation('sender', function ($query) use ($term) {
                        $query->where('name', 'ILIKE', "%$term%")
                            ->orWhere('surname', 'ILIKE', "%$term%")
                            ->orWhere('patronymic', 'ILIKE', "%$term%");
                    });
            }, function ($query) {
                $query->has('sender');
            })
            // ->where('status_id', $completedStatusID)
            ->whereHas('receiver', function ($query) {
                $query->where('is_deleted', false);
            })
            ->latest('id')
            ->paginate($request->get('per_page', 10));

        return response()->json($data);
    }

    public function sentMessagesList(Request $request)
    {
        $term = $request->search_string;
        $completedStatusID = MessageStatus::statusID('completed');
        $data = Message::with(['receivers.employee', 'sender'])
            ->where('sender_id', auth()->id())
            ->where('status_id', $completedStatusID)
            ->when($term, function ($query, $term) {
                $query->whereHas('receivers', function ($query) use ($term) {
                    $query->whereHas('employee', function ($query) use ($term) {
                        $query->where('name', 'ILIKE', "%$term%")
                            ->orWhere('surname', 'ILIKE', "%$term%")
                            ->orWhere('patronymic', 'ILIKE', "%$term%");
                    });
                    $query->orWhereHas('student', function ($query) use ($term) {
                        $query->where('name', 'ILIKE', "%$term%")
                            ->orWhere('surname', 'ILIKE', "%$term%")
                            ->orWhere('last_name', 'ILIKE', "%$term%");
                    });
                });
            })
            ->latest('id')
            ->paginate($request->get('per_page', 10));

        return SendMessageResource::collection($data)->resource;
    }

    public function draftMessagesList(Request $request)
    {
        $term = $request->search_string;
        $draftStatusID = MessageStatus::statusID('draft');
        $data = Message::with(['receivers'])
            ->where('sender_id', auth()->id())
            ->where('status_id', $draftStatusID)
            ->when($term, function ($query, $term) {
                $query->whereHas('receivers', function ($query) use ($term) {
                    $query->whereHas('employee', function ($query) use ($term) {
                        $query->where('name', 'ILIKE', "%$term%")
                            ->orWhere('surname', 'ILIKE', "%$term%")
                            ->orWhere('patronymic', 'ILIKE', "%$term%");
                    });
                    $query->orWhereHas('student', function ($query) use ($term) {
                        $query->where('name', 'ILIKE', "%$term%")
                            ->orWhere('surname', 'ILIKE', "%$term%")
                            ->orWhere('last_name', 'ILIKE', "%$term%");
                    });
                });
            })
            ->latest('id')
            ->paginate($request->get('per_page', 10));

        return response()->json($data);
    }

    public function fetchDraftMessageByID(Request $request, Message $message)
    {
        $data = $message->load(['receivers' => function ($query) {
            $query->has('student')
                ->orHas('employee')
                ->with([
                    'student:id,user_id,name,surname,last_name,image',
                    'employee:id,user_id,name,surname,patronymic,image'
                ]);
        }]);

        return response()->json($data);
    }

    public function deletedMessagesList(Request $request)
    {
        $term = $request->search_string;
        $deletedStatusID = MessageStatus::statusID('deleted');
        $data = Message::where('sender_id', auth()->id())
            ->where('status_id', $deletedStatusID)
            ->orWhereRelation('receiver', 'is_deleted', true)
            ->when($term, function ($query, $term) {
                $query->whereHas('sender', function ($query) use ($term) {
                    $query->where('name', 'ILIKE', "%$term%")
                        ->orWhere('surname', 'ILIKE', "%$term%")
                        ->orWhere('patronymic', 'ILIKE', "%$term%");
                });
            })
            ->with(['receivers', 'sender'])
            ->latest('id')
            ->paginate($request->get('per_page', 10));

        return DeleteMessageResource::collection($data)->resource;
    }

    public function store(MessageRequest $request)
    {
        // $result = new MessageProResource($message->store($request));

        $message_status_id = MessageStatus::statusID('completed');
        $message = Message::create([
            'sender_id' => auth()->id(),
            'theme' => $request->theme,
            'message' => $request->message,
            'status_id' => $message_status_id ?? null,
        ]);

        $receivers = $request->users;

        foreach ($receivers as $userId) {
            if ($userId == auth()->id()) continue;

            MessageReceiver::create([
                'user_id' => $userId,
                'message_id' => $message->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json(['message' => 'success']);
    }

    public function saveDraftMessage(Request $request)
    {
        $message_status_id = MessageStatus::statusID('draft');
        $message = Message::create([
            'sender_id' => auth()->id(),
            'theme' => $request->theme,
            'message' => $request->message,
            'status_id' => $message_status_id ?? null,
        ]);

        $receivers = $request->users;

        foreach ($receivers as $userId) {
            if ($userId == auth()->id()) continue;

            MessageReceiver::create([
                'user_id' => $userId,
                'message_id' => $message->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json(['message' => 'success']);
    }

    public function updateDraftMessage(Request $request, Message $message)
    {
        $message->update([
            'theme' => $request->theme,
            'message' => $request->message,
        ]);

        $receivers = $request->users;

        foreach ($receivers as $userId) {
            if ($userId == auth()->id()) continue;

            MessageReceiver::updateOrCreate(
                [
                    'user_id' => $userId,
                    'message_id' => $message->id,
                ],
                [
                    'updated_at' => date('Y-m-d H:i:s')

                ]
            );
        }

        return response()->json(['message' => 'success']);
    }

    public function show($id, MessageServiceInterface $service)
    {
        $result = new MessageResource($service->show($id));
        return response()->json($result);
    }

    public function updateMessage(MessageRequest $request, Message $message)
    {
        $message_status_id = MessageStatus::statusID('completed');
        $message->update([
            'theme' => $request->theme,
            'message' => $request->message,
            'status_id' => $message_status_id ?? null,
            'old_status' => 'draft',
        ]);

        $receivers = $request->users;

        foreach ($receivers as $userId) {
            if ($userId == auth()->id()) continue;

            MessageReceiver::updateOrCreate(
                [
                    'user_id' => $userId,
                    'message_id' => $message->id
                ],
                [
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        return response()->json(['message' => 'success']);
    }

    public function deleteMany(Request $request)
    {
        try {
            if ($request->has('ids')) {
                foreach ($request->ids as $key => $id) {
                    $message = Message::find($id);

                    if ($message->sender_id === auth()->id()) {
                        if ($message->status_id == MessageStatus::statusID('deleted')) {
                            $message->update([
                                'status_id' => MessageStatus::statusID('force-deleted'),
                                'old_status' => 'deleted'
                            ]);
                        } else $message->update([
                            'status_id' => MessageStatus::statusID('deleted'),
                            'old_status' => $message->message_status->key
                        ]);
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
                    }
                }

                return response()->json(['message' => 'success']);
            }
        } catch (Throwable $th) {
            // throw $th;
            return response()->json(['message' => $th], 422);
        }
    }

    public function destroy($id, MessageServiceInterface $message)
    {
        $result = $message->delete($id);
        return response()->json($result);
    }

    public function restoreMany(MessageRestoreRequest $request)
    {
        foreach ($request->ids as $key => $id) {
            $message = Message::findOrFail($id);
            if ($message->sender_id === auth()->id()) {
                $message->update([
                    'status_id' => MessageStatus::statusID('completed'),
                    'old_status' => 'deleted'
                ]);
            } else {
                $receiver = MessageReceiver::where('message_id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($receiver?->is_deleted) {
                    $receiver->update([
                        'is_deleted' => false
                    ]);
                }
            }
        }

        return response()->json(['message' => 'success']);
    }

    public function fetchEmployeesList(Request $request)
    {
        $data = Employee::with('departments:id,name')
            //   ->whereHas('departments', function ($query) {
            //     $query->where('type', 'faculty');
            //   })
            ->when($request->department_id, function ($coll, $value) {
                $coll->whereHas('departments', function ($query) use ($value) {
                    $query->where('departments.id', $value);
                });
            })
            ->when($request->search_string, function ($coll, $value) {
                $coll->where('name', 'ILIKE', "%$value%")
                    ->orWhere('surname', 'ILIKE', "%$value%")
                    ->orWhere('patronymic', 'ILIKE', "%$value%")
                    ->orWhere('passport_number', 'ILIKE', "%$value%");
            })
            ->whereNot('user_id', auth()->id())
            ->whereNotNull('user_id')
            ->select([
                'id',
                'user_id',
                'surname',
                'name',
                'patronymic',
            ])
            ->customPaginate();

        return response()->json($data);
    }

    public function fetchStudentsList(Request $request)
    {
        $data = Student::with(['academic_group:id,name'])
            ->whereNotNull('user_id')
            ->when($request->academic_group_id, function ($coll, $value) {
                $coll->whereHas('academic_group', function ($query) use ($value) {
                    $query->where('id', $value);
                });
            })
            ->when($request->search_string, function ($coll, $value) {
                $coll->where('name', 'ILIKE', "%$value%")
                    ->orWhere('surname', 'ILIKE', "%$value%")
                    ->orWhere('patronymic', 'ILIKE', "%$value%")
                    ->orWhere('passport_number', 'ILIKE', "%$value%");
            })
            ->customPaginate();

        return response()->json($data);
    }

    public function markMessageAsRead(Request $request, MessageReceiver $messageReceiver)
    {
        $messageReceiver->update([
            'is_seen' => true
        ]);

        return response()->json(['message' => 'success']);
    }
}