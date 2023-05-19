<?php

namespace App\Repository\Report;

use App\Models\Academic\AcademicGroupExam;
use App\Models\Additional\Department;
use App\Models\Additional\Audience;
use App\Models\Attendance\Action;
use App\Models\Curriculum\CurriculumSubject;
use App\Models\User\Employee;
use Closure;

class ReportRepository
{
    public static function getInstance(): ReportRepository
    {
        return new static();
    }

    public function action(Closure $closure)
    {
        return $closure(Action::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function resources(Closure $closure)
    {
        return $closure(CurriculumSubject::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function audiences(Closure $closure)
    {
        return $closure(Audience::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function teachers(Closure $closure)
    {
        return $closure(Employee::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function exams(Closure $closure)
    {
        return $closure(AcademicGroupExam::query())
            ->paginate(request()->get('per_page', 10));
    }
}