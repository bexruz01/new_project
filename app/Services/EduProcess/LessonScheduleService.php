<?php

namespace App\Services\EduProcess;

use App\Http\Resources\EduProcess\LessonSchedule\LessonScheduleResource;
use App\Http\Resources\EduProcess\LessonSchedule\LessonSchedulesResource;
use App\Http\Requests\EduPlan\LessonScheduleFilterRequest;
use App\Repository\EduProcess\EduProcessRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Lesson\LessonSchedule;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;

class LessonScheduleService
{
    use ApiResponse;

    protected $repository;

    public function __construct(EduProcessRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): LessonScheduleService
    {
        return new static(EduProcessRepository::getInstance());
    }

    public function lesson_schedules($request)
    {
        $result = $this->repository->lesson_schedules(function (Builder $builder) {
            return $builder->with(['academic_group'])
                ->withWhereHas('semester', function ($query) {
                    $query->whereEqual('edu_plan_id')
                        ->withWhereHas('edu_plan', function ($query) {
                            $query->whereEqual('faculty_id')
                                ->whereEqual('edu_form_id');
                        })->whereEqual('academic_year_id');
                })
                ->withWhereHas('lesson_schedule_topics', function ($query) {
                    $query->select('week_id', 'lesson_schedule_id', DB::raw('count(*)'))
                        ->with('week')
                        ->groupBy('week_id', 'lesson_schedule_id');
                })
                ->whereEqual('academic_group_id')
                ->whereEqual('semester_id');
        });
        return $this->successPaginate(LessonSchedulesResource::collection($result));;
    }

    public function lesson_schedule($id)
    {
        $model = LessonSchedule::with('lesson_schedule_topics')->find($id);
        if (!$model) return $this->errorResponse(__('message.Not found'));
        return $this->successResponse(new LessonScheduleResource($model));
    }
}