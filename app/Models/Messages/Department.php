<?php

namespace App\Models\Messages;

use App\Models\Employees\Employee;
use App\Models\Students\Student;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public array $translatable = ['name'];
    protected $fillable = [
        'name',
        'code',
        'type',
        'status',
        'department_type_id',
        'department_id'
    ];
    protected $table = "departments";
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function department_type()
    {
        return $this->belongsTo(DepartmentType::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'department_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'faculty_id', 'id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'work_contracts', 'department_id', 'employee_id');
    }

    public function faculty()
    {
        return $this->hasOne(Department::class, 'id', 'department_id')
            ->where('type', 'faculty');
    }
}
