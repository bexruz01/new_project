<?php

namespace App\Models\User;

use App\Models\Lesson\LessonScheduleTopic;
use App\Models\Exam\ExamScheduleSubject;
use App\Models\Academic\AcademicDegree;
use App\Models\Additional\WorkContract;
use App\Models\Additional\Specialty;
use App\Models\Rating\RatingCritery;
use App\Models\Rating\Publication;
use App\Filters\Filterable;
use App\Models\Additional\Department;
use App\Traits\Scopes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, SoftDeletes, Scopes, Filterable;

    public $table = "employees";

    public $fillable = [
        'passport_date',
        'pinfl',
        'passport_number',
        'surname',
        'name',
        'patronymic',
        'image',
        'birthdate',
        'gender',
        'address_home',
        'speciality',
        'recruitment_date',
        'email',
        'phone',
        'status',
        'work_count',
        'country_id',
        'region_id',
        'district_id',
        'nation_id',
        'academic_degree_id',
        'academic_title_id',
        'user_id',
        'citizenship_id'
    ];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public array $fileFields = ['image'];

    public function getImageAttribute($value)
    {
        return getImageOriginal('employee', $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function work_contract()
    {
        return $this->hasOne(WorkContract::class, 'employee_id', 'id')->latest();
    }

    public function lesson_topic()
    {
        return $this->hasMany(LessonScheduleTopic::class, 'employee_id', 'id');
    }

    public function rating()
    {
        return $this->belongsToMany(RatingCritery::class, 'publication_employees', 'employee_id', 'rating_criteria_id');
    }

    public function publication()
    {
        return $this->belongsToMany(Publication::class, 'publication_employees', 'employee_id', 'publication_id');
    }

    public function academic_degree()
    {
        return $this->hasOne(AcademicDegree::class, 'id', 'academic_degree_id');
    }

    public function specialty()
    {
        return $this->hasOne(Specialty::class, 'id', 'specialty_id');
    }

    //  Accessors
    public function getFullNameAttribute(): string
    {
        return implode(' ', [$this->surname, $this->name, $this->patronymic]);
    }

    public function exam_schedule_subjects()
    {
        return $this->hasMany(ExamScheduleSubject::class, 'audience_id')
            ->orderBy('date')->whereBetween2('date');
    }

    public function lesson_schedule_topics()
    {
        return $this->hasMany(LessonScheduleTopic::class)
            ->orderBy('date')->whereBetween2('date');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'work_contracts');
    }
}