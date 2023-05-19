<?php

namespace App\Http\Controllers\EduProcess;

use App\Services\EduProcess\LessonScheduleService;
use App\Services\EduProcess\ExamScheduleService;
use App\Services\EduProcess\EduPlanService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EduPlan\EduPlanFilterRequest;
use App\Http\Requests\EduPlan\ExamScheduleFilterRequest;
use App\Http\Requests\EduPlan\LessonScheduleFilterRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class EduProcessController extends Controller
{
    use ApiResponse;

    /**************************************************** */
    public function edu_plans(EduPlanFilterRequest $request)
    {
        return EduPlanService::getInstance()->edu_plans($request);
    }

    public function edu_plan($id)
    {
        return EduPlanService::getInstance()->edu_plan($id);
    }

    public function curriculum($id)
    {
        return EduPlanService::getInstance()->curriculum($id);
    }

    /***************************************************** */
    public function lesson_schedules(LessonScheduleFilterRequest $request)
    {
        return LessonScheduleService::getInstance()->lesson_schedules($request);
    }

    public function lesson_schedule($id)
    {
        return LessonScheduleService::getInstance()->lesson_schedule($id);
    }

    /***************************************************** */
    public function exam_schedules(ExamScheduleFilterRequest $request)
    {
        return ExamScheduleService::getInstance()->exam_schedules($request);
    }

    public function exam_schedule($id)
    {
        return ExamScheduleService::getInstance()->exam_schedule($id);
    }
}