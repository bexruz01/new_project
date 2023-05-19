<?php

namespace App\Models\Exam;

use App\Traits\Scopes;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamStudent extends Model
{
    use HasFactory, Scopes;

    public function student() {
        return $this->hasOne(Student::class,'id','student_id');
    }

    public function exam() {
        return $this->hasOne(Exam::class,'id','student_id');
    }
}
