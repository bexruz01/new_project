<?php

namespace App\Repository\Attendance;

use App\Models\Academic\AcademicGroup;
use App\Models\Additional\Department;
use App\Models\Attendance\StudentAttendance;
use App\Models\Lesson\LessonScheduleTopic;
use App\Models\User\Employee;
use App\Models\User\Student;
use Closure;

class AttendanceRepository
{

    public static function getInstance()
    {
        return new static();
    }

    public function report(Closure $closure)
    {
        return $closure(StudentAttendance::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function subject(Closure $closure)
    {
        return $closure(AcademicGroup::query())
            ->first();
    }

    public function lesson_schedule_topic(Closure $closure)
    {
        return $closure(LessonScheduleTopic::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function faculty(Closure $closure)
    {
        return $closure(Department::query())
            ->where('type', 'faculty')
            ->paginate(request()->get('per_page', 10));
    }

    public function group(Closure $closure)
    {
        return $closure(AcademicGroup::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function pair(Closure $closure)
    {
        return $closure(LessonScheduleTopic::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function teacher(Closure $closure)
    {
        return $closure(Employee::query())
            ->paginate(request()->get('per_page', 10));
    }
}