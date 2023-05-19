<?php

namespace App\Models\Exam;

use App\Models\Academic\AcademicGroup;
use App\Models\Education\Semester;
use App\Models\Education\Subject;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchedule extends Model
{
    use HasFactory, Scopes;

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function academic_group()
    {
        return $this->belongsTo(AcademicGroup::class, 'academic_group_id', 'id');
    }

    public function exam_schedule_subjects()
    {
        return $this->hasMany(ExamScheduleSubject::class, 'exam_schedule_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'exam_schedule_subjects', 'exam_schedule_id', 'subject_id');
    }
}