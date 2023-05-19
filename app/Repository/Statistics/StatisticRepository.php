<?php

namespace App\Repository\Statistics;

use App\Models\Academic\AcademicGroupSubject;
use App\Models\Curriculum\CurriculumSubject;
use App\Models\Education\SubjectTopic;
use App\Models\Additional\Department;
use App\Models\Education\EduPlan;
use App\Models\User\Student;
use Closure;

class StatisticRepository
{
    public static function getInstance(): StatisticRepository
    {
        return new static();
    }

    public function faculty(Closure $closure)
    {
        return $closure(Department::query())
            ->where('type', 'faculty')
            ->get();
    }

    public function student(Closure $closure)
    {
        return $closure(Student::query())->paginate(request()->get('per_page',10));
    }

    public function curriculum_subject(Closure $closure)
    {
        return $closure(CurriculumSubject::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function edu_plan(Closure $closure)
    {
        return $closure(EduPlan::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function training(Closure $closure)
    {
        return $closure(AcademicGroupSubject::query())
            ->get();
    }
}