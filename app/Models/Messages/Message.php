<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Employee;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "messages";

    protected $attributes = ['view_count' => 0];

    protected $guarded = [];
    public static $STATUS_INCOMING = 'completed';
    public static $STATUS_SENT = 'sent';
    public static $STATUS_DRAFT = 'draft';
    public static $STATUS_DELETED = 'deleted';

    protected $casts = [
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function saveData($request)
    {
        $messaga_status_id = MessageStatus::where('key', 'completed')->first();
        $message = Message::create([
            'sender_id' => auth()->user()->getAuthIdentifier(),
            'theme' => $request->theme,
            'message' => $request->message,
            'status_id' => $messaga_status_id->id ?? null,
        ]);
        if ($request->has('userIds')) {
            $userIds = $request->userIds;
            foreach ($userIds as $userId) {
                if ($userId == auth()->id())
                    continue;
                MessageReceiver::create([
                    'user_id' => $userId,
                    'message_id' => $message->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public static function saveDraftMessage($request)
    {
        $messaga_status_id = MessageStatus::where('key', 'draft')->first();
        $message = Message::create([
            'sender_id' => auth()->user()->getAuthIdentifier(),
            'theme' => $request->theme,
            'message' => $request->message,
            'status_id' => $messaga_status_id->id ?? null,
        ]);
        if ($request->has('userIds')) {
            $userIds = $request->userIds;
            foreach ($userIds as $userId) {
                if ($userId == auth()->id())
                    continue;
                MessageReceiver::create([
                    'user_id' => $userId,
                    'message_id' => $message->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public function message_status()
    {
        return $this->belongsTo(MessageStatus::class, 'status_id');
    }

    public function receivers()
    {
        return $this->hasMany(MessageReceiver::class, 'message_id', 'id')
            // ->where('is_deleted', false)
            // ->has('student')
            // ->orHas('employee')
            ->with([
                'student:id,user_id,name,surname,last_name,image',
                'employee:id,user_id,name,surname,patronymic,image'
            ]);
    }

    public function receiver()
    {
        return $this->hasOne(MessageReceiver::class, 'message_id', 'id')
            ->where('user_id', auth()->id());
    }

    public function sender()
    {
        return $this->belongsTo(Employee::class, 'sender_id', 'user_id');
    }
}