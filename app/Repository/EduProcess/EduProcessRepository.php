<?php

namespace App\Repository\EduProcess;

use App\Models\Education\EduPlan;
use App\Models\Exam\ExamSchedule;
use App\Models\Lesson\LessonSchedule;
use Closure;

class EduProcessRepository
{

    public static function getInstance()
    {
        return new static();
    }

    public function edu_plans(Closure $closure)
    {
        return $closure(EduPlan::query())
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('per_page', 10));
    }

    public function lesson_schedules(Closure $closure)
    {
        return $closure(LessonSchedule::query())
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('per_page', 10));
    }

    public function exam_schedules(Closure $closure)
    {
        return $closure(ExamSchedule::query())
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('per_page', 10));
    }
}