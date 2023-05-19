<?php

namespace App\Services\EduProcess;

use App\Http\Resources\EduProcess\EduPlan\CurriculumEduProcessResource;
use App\Http\Resources\EduProcess\EduPlan\EduPlanResource;
use App\Http\Resources\EduProcess\EduPlan\EduPlansResource;
use App\Filters\EduProcess\EduPlanEduProcessFilter;
use App\Repository\EduProcess\EduProcessRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Curriculum\Curriculum;
use App\Models\Education\Semester;
use App\Models\Education\EduPlan;
use App\Traits\ApiResponse;

class EduPlanService
{
    use ApiResponse;

    protected $repository;


    public function __construct(EduProcessRepository $repo)
    {
        return $this->repository = $repo;
    }


    public static function getInstance(): EduPlanService
    {
        return new static(EduProcessRepository::getInstance());
    }


    public function edu_plans($request)
    {
        $filter = new EduPlanEduProcessFilter($request);

        $result = $this->repository->edu_plans(function (Builder $builder) use ($filter) {
            return $builder->with(['specialty', 'faculty', 'rating_system'])
                ->withWhereHas('curriculums', function ($query) {
                    $query->withCount('subjects');
                })->withCount(['academic_groups', 'weeks'])
                ->filter($filter);
        });
        return $this->successPaginate(EduPlansResource::collection($result));;
    }


    public function edu_plan($id)
    {
        $result = EduPlan::find($id);
        if (!$result) return $this->errorResponse(__('message.Not found'));

        $model = Semester::where('edu_plan_id', $id)
            ->withWhereHas('curriculums', function ($query) use ($id) {
                $query->where('edu_plan_id', $id)
                    ->with(['subjects.subject_type']);
            })
            ->get();
        $result['semesters'] = $model;
        return $this->successResponse(new EduPlanResource($result));;
    }


    public function curriculum($id)
    {
        $model = Curriculum::with([
            'audiance_hours.lesson_activity', 'exam_types.exam_type'
        ])->find($id);

        if (!$model) return $this->errorResponse(__('message.Not found'));

        return $this->successResponse(new CurriculumEduProcessResource($model));
    }
}