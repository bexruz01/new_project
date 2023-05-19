<?php

namespace App\Models\Exam;

use App\Models\User\Student;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleResult extends Model
{
    use HasFactory, Scopes;

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function exam_schedule_subject()
    {
        return $this->hasOne(ExamScheduleSubject::class, 'exam_schedule_id', 'id');
    }
}