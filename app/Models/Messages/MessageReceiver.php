<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Employee;
use App\Models\User\Student;

class MessageReceiver extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "message_receivers";
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function message()
    {
        return $this->belongsTo(Message::class)
            ->with('sender')
            ->with('status');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }
}