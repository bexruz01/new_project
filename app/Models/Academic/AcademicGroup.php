<?php

namespace App\Models\Academic;

use App\Traits\Scopes;
use App\Models\User\Student;
use App\Models\Education\EduPlan;
use App\Models\Education\Subject;
use App\Models\Lesson\LessonSchedule;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson\LessonScheduleTopic;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicGroup extends Model
{
    use HasFactory, Scopes, HasTranslations;
    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function academic_group_subjects()
    {
        return $this->hasMany(AcademicGroupSubject::class, 'academic_group_id', 'id');
    }


    /** Akademik guruhga tegishli o'quv rejasini, guruhi bilan olish; */
    public function edu_plan()
    {
        return $this->hasOne(EduPlan::class, 'id', 'edu_plan_id');
        //->with(['academic_year', 'edu_form']);
    }

    /** Shu guruhga tegishli studentlarni olish; */
    public function students()
    {
        return $this->hasMany(Student::class, 'academic_group_id', 'id');
    }

    /** Shu guruh darslarini olish; */
    public function lesson_topic()
    {
        return $this->hasManyThrough(LessonScheduleTopic::class, LessonSchedule::class, 'academic_group_id', 'lesson_schedule_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'academic_group_subjects');
    }
}