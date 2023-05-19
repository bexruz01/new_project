<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\AcademicGroup;
use App\Models\Education\EduPlan;
use App\Models\Education\Subject;
use App\Traits\HasTranslations;
use App\Models\User\Employee;
use App\Models\User\Student;
use App\Filters\Filterable;
use App\Traits\Scopes;

class Department extends Model
{
    use HasFactory, HasTranslations, Filterable, Scopes;

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    /** Ushbu facultetga teshishli guruhlarni olish; */
    public function academic_groups()
    {
        return $this->hasManyThrough(AcademicGroup::class, EduPlan::class, 'faculty_id', 'edu_plan_id');
    }

    /** Kafedraga tegishli ishchilarni olish; */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'work_contracts', 'department_id', 'employee_id');
    }

    /** Fakultetga tegishli kafedralarni olish; */
    public function departments()
    {
        return ($this->hasMany(Department::class, 'department_id', 'id')
            ->where('type', 'department'));
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'faculty_id', 'id');
    }

    public function specialties()
    {
        return $this->hasMany(Specialty::class, 'faculty_id', 'id');
    }

    /** Kafedra fanlari; */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'curriculum_subjects');
    }

    public function faculty()
    {
        return $this->hasOne(Department::class, 'id', 'department_id')
            ->where('type', 'faculty');
    }
}