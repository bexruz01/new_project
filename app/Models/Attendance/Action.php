<?php

namespace App\Models\Attendance;

use App\Filters\Filterable;
use App\Traits\Scopes;
use App\Models\User\Student;
use App\Models\User\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory, Scopes, Filterable;

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Employee::class, 'user_id', 'user_id');
    }
}