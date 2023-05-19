<?php

namespace App\Models\Exam;

use App\Models\Curriculum\CurriculumExamType;
use App\Models\Education\Subject;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleSubject extends Model
{
    use HasFactory, Scopes;

    public function exam_schedule() {
        return $this->hasOne(ExamSchedule::class,'id','exam_schedule_id');
    }

    public function subject() {
        return $this->hasOne(Subject::class,'id','subject_id');
    }

    public function exam_type() {
        return $this->hasOne(ExamType::class,'id','exam_type_id');
    }

    public function exam_schedule_results() {
        return $this->hasMany(ExamScheduleResult::class,'exam_schedule_id','id');
    }

    public function curriculum_exam_type() {
        return $this->hasOne(CurriculumExamType::class,'exam_type_id','exam_type_id');
    }
    
}
