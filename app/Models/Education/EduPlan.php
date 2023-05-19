<?php

namespace App\Models\Education;

use App\Filters\Filterable;
use App\Models\Academic\AcademicGroup;
use App\Models\Academic\AcademicYear;
use App\Models\Additional\Department;
use App\Models\Additional\Reference;
use App\Models\Additional\Specialty;
use App\Models\Additional\Week;
use App\Models\Curriculum\Curriculum;
use App\Models\Rating\RatingSystem;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduPlan extends Model
{
    use HasFactory, Scopes, Filterable, HasTranslations;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    /** O'quv rejasi tegishli bo'lgan o'qub yilini olish; */
    public function academic_year()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id');
    }

    /** O'quv rejasi tegishli bo'lgan fakultetni olish; */
    public function faculty()
    {
        return $this->hasOne(Department::class, 'id', 'faculty_id');
    }

    /** O'quv rejasi tegishli bo'lgan mutaxasislikni olish; */
    public function specialty()
    {
        return $this->hasOne(Specialty::class, 'id', 'specialty_id')->with(['edu_type']);
    }

    /** O'quv rajasi tegishli bo'lgan TA'LIM TURI ni olish; */
    public function edu_form()
    {
        return $this->hasOne(Reference::class, 'id', 'edu_form_id');
    }

    /** O'quv rejasi tegishli bo'lgan baholash tizimini olish; */
    public function rating_system()
    {
        return $this->hasOne(RatingSystem::class, 'id', 'rating_system_id');
    }

    /** O'quv rejaga bog'langan guruhlarni olish; */
    public function academic_groups()
    {
        return $this->hasMany(AcademicGroup::class, 'edu_plan_id', 'id');
    }

    /** O'quv rejaga bo'glangan O'QUV DASTURIni olish */
    public function curriculums()
    {
        return $this->hasMany(Curriculum::class, 'edu_plan_id', 'id');
    }

    /** O'quv rejaga bog'langan haftalarni olish; */
    public function weeks()
    {
        return $this->hasMany(Week::class, 'edu_plan_id', 'id');
    }

    /** O'quv rejasiga tegishli semesterlarni olish; */
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}