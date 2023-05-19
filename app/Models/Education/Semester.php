<?php

namespace App\Models\Education;

use App\Models\Academic\AcademicYear;
use App\Models\Curriculum\Curriculum;
use App\Models\Curriculum\CurriculumSubject;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class, 'semester_id', 'id');
    }

    public function curriculum_subjects()
    {
        return $this->hasManyThrough(CurriculumSubject::class, Curriculum::class, 'semester_id', 'curriculum_id');
    }

    public function edu_plan()
    {
        return $this->belongsTo(EduPlan::class);
    }

    public function academic_year()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}