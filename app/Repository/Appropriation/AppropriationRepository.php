<?php

namespace App\Repository\Appropriation;

use App\Models\Exam\ExamScheduleResult;
use App\Models\Exam\ExamScheduleSubject;
use App\Models\Exam\ExamStudent;
use App\Models\User\Student;
use Closure;

class AppropriationRepository
{

    public static function getInstance()
    {
        return new static();
    }

    public function rating_reports(Closure $closure)
    {
        return $closure(ExamScheduleSubject::query())
            // ->orderBy('created_at')
            ->paginate(request()->get('per_page', 10));
    }

    public function summary_report(Closure $closure)
    {
        return $closure(Student::query())
            ->paginate(request()->get('per_page', 10));
    }

    public function academic_debt(Closure $closure)
    {
        return $closure(ExamScheduleResult::query())
            ->get();
    }
}