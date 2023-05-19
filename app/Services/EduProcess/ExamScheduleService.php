<?php

namespace App\Services\EduProcess;

use App\Http\Resources\EduProcess\ExamSchedule\ExamScheduleResource;
use App\Http\Resources\EduProcess\ExamSchedule\ExamSchedulesResource;
use App\Repository\EduProcess\EduProcessRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\Exam\ExamSchedule;
use App\Traits\ApiResponse;


class ExamScheduleService
{
    use ApiResponse;

    protected $repository;

    public function __construct(EduProcessRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): ExamScheduleService
    {
        return new static(EduProcessRepository::getInstance());
    }

    public function exam_schedules($request)
    {
        $result = $this->repository->exam_schedules(function (Builder $builder) {
            return $builder->whereEqual('academic_group_id')
                ->whereEqual('semester_id')
                ->withWhereHas('semester', function ($query) {
                    $query->whereEqual('academic_year_id')
                        ->whereEqual('edu_plan_id')
                        ->withWhereHas('edu_plan', function ($query) {
                            $query->whereEqual('faculty_id')
                                ->whereEqual('edu_form_id');
                        })
                        ->with(['academic_year']);
                })
                ->withWhereHas('exam_schedule_subjects', function ($query) {
                    $query->select('subject_id', 'exam_schedule_id', DB::raw('count(*) as count'))
                        ->with('subject')
                        ->groupBy('subject_id', 'exam_schedule_id');
                });
        });
        return $this->successPaginate(ExamSchedulesResource::collection($result));
    }

    public function exam_schedule($id)
    {
        $model = ExamSchedule::find($id);
        if (!$model) return $this->errorResponse(__('message.Not found'));
        return $this->successResponse(new ExamScheduleResource($model));
    }
}