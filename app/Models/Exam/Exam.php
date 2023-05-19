<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\AcademicYear;
use App\Models\Education\EduPlan;
use App\Models\Education\Semester;
use App\Models\Education\Subject;
use App\Models\User\Employee;
use App\Traits\HasTranslations;
use App\Traits\Scopes;

class Exam extends Model
{
    use HasFactory, Scopes, HasTranslations;
    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function edu_plan()
    {
        return $this->hasOne(EduPlan::class, 'id', 'edu_plan_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function academic_year()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}