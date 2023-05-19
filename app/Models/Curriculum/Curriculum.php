<?php

namespace App\Models\Curriculum;

use App\Models\Education\EduPlan;
use App\Models\Education\Semester;
use App\Models\Education\Subject;
use App\Models\Education\SubjectTopic;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory, Scopes;
    protected $table = 'curriculums';


    /** Fanlarni olish; */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'curriculum_subjects', 'curriculum_id', 'subject_id');
    }

    /** O'quv dasturi tegishli bo'lgan semesterni olish */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    /** Mashg'ulot turlarini olish; */
    public function audiance_hours()
    {
        return $this->hasMany(CurriculumAudianceHour::class);
    }

    /** Nazorat turlarini olish; */
    public function exam_types()
    {
        return $this->hasMany(CurriculumExamType::class);
    }

    public function edu_plan()
    {
        return $this->hasOne(EduPlan::class, 'id', 'edu_plan_id');
    }

    public function subject_topics()
    {
        return $this->hasMany(SubjectTopic::class, 'curriculum_id', 'id');
    }

    public function curriculum_subjects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CurriculumSubject::class);
    }
}