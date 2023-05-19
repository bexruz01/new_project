<?php

namespace App\Models\Attendance;

use App\Traits\Scopes;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson\LessonScheduleTopic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAttendance extends Model
{
    use HasFactory, Scopes;

    public function student() {
        return $this->hasOne(Student::class,'id','student_id');
    }

    public function lesson_schedule_topic() {
        return $this->hasOne(LessonScheduleTopic::class,'id','lesson_schedule_topic_id');
    }
}