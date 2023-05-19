<?php

namespace App\Models\Education;

use App\Models\Additional\Reference;
use App\Models\Attendance\StudentAttendance;
use App\Models\Exam\ExamScheduleSubject;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public $translatable = ['name'];

    /** Accessor */
    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function subject_type()
    {
        return $this->belongsTo(Reference::class, 'subject_type_id', 'id');
    }

    public function subject_topics()
    {
        return $this->hasMany(SubjectTopic::class, 'subject_id', 'id');
    }

    public function student_attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'id', 'subject_id');
    }

    public function subject_topic_resources()
    {
        return $this->hasManyThrough(SubjectTopicResource::class, SubjectTopic::class, 'subject_id', 'subject_topic_id');
    }

    // public function exam_schedule_subjects()
    // {
    //     return $this->hasMay(ExamScheduleSubject::class, 'id', 'subject_id');
    // }
}