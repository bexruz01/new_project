<?php

namespace App\Services\Appropriation;

use App\Http\Requests\Appropriation\AcademicDebtAppropriationFilterRequest;
use App\Http\Requests\Appropriation\RatingReportAppropriationFilterRequest;
use App\Http\Requests\Appropriation\SummaryReportAppropriationFilterRequest;
use App\Http\Resources\Appropriation\AcademicDebtAppropriationResource;
use App\Http\Resources\Appropriation\SummaryReportsResource;
use App\Http\Resources\Appropriation\RatingReportsResource;
use App\Http\Resources\Appropriation\RatingReportResource;
use App\Repository\Appropriation\AppropriationRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Exam\ExamScheduleSubject;
use App\Models\Academic\AcademicGroup;
use App\Traits\ApiResponse;

class AppropriationService
{
    use ApiResponse;

    protected $repository;

    public function __construct(AppropriationRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): AppropriationService
    {
        return new static(AppropriationRepository::getInstance());
    }

    public function rating_reports($request)
    {
        $validator = Validator::make($request->all(), RatingReportAppropriationFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse(__('message.Not found'));

        $result = $this->repository->rating_reports(function (Builder $builder) use ($request) {
            return $builder
                ->when($request->subject_id, function ($query) {
                    $query->where('subject_id', request('subject_id'));
                })->withWhereHas('exam_schedule', function ($query) use ($request) {
                    $query->when($request->academic_group_id, function ($query) {
                        $query->where('academic_group_id', request('academic_group_id'));
                    })->when($request->semester_id, function ($query) {
                        $query->where('semester_id', request('semester_id'));
                    })->withWhereHas('semester', function ($query) use ($request) {
                        $query->when($request->academic_year_id, function ($query) {
                            $query->where('academic_year_id', request('academic_year_id'));
                        })->with('academic_year');
                    })->withWhereHas('academic_group', function ($query) use ($request) {
                        $query->when($request->edu_plan_id, function ($query) {
                            $query->where('edu_plan_id', request('edu_plan_id'));
                        })->withWhereHas('edu_plan', function ($query) use ($request) {
                            $query->when($request->faculty_id, function ($query) {
                                $query->where('faculty_id', request('faculty_id'));
                            });
                        });
                    });
                })->with('exam_type');
        });
        return $this->successPaginate(RatingReportsResource::collection($result));
    }

    public function rating_report($id)
    {
        $model = ExamScheduleSubject::find($id);
        if (!$model) return $this->errorResponse(__('message.Not found'));
        return $this->successResponse(new RatingReportResource($model));
    }

    public function summary_report($request)
    {
        $validator = Validator::make($request->all(), SummaryReportAppropriationFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse(__('message.Not found'));

        $result = AcademicGroup::where('id', $request->academic_group_id)
            ->withWhereHas('academic_group_subjects', function ($query) use ($request) {
                $query->whereHas('curriculum', function ($query) use ($request) {
                    $query->where('semester_id', $request->semester_id)
                        ->where('edu_plan_id', $request->edu_plan_id)
                        ->whereHas('semester', function ($query) {
                            $query->whereEqual('academic_year_id');
                        });
                })->with('subject');
            })
            ->withWhereHas('students', function ($query) {
                $query->withWhereHas('exam_schedule_results', function ($query) {
                    $query->withWhereHas('exam_schedule_subject', function ($query) {
                        $query
                            //     ->whereHas('exam_type', function ($query) {
                            //         $query; //->where('name', 'final');
                            //     })
                            ->withWhereHas('exam_schedule', function ($query) {
                                $query->whereEqual('semester_id')
                                    ->whereEqual('academic_group_id');
                            });
                    });
                });
            })
            ->first();

        return $this->successResponse(
            new SummaryReportsResource($result)
        );
    }

    public function academic_debt($request)
    {
        $validator = Validator::make($request->all(), AcademicDebtAppropriationFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->academic_debt(function (Builder $builder) {
            return $builder->where('rating', '<', 3)
                ->withWhereHas('student', function ($query) {
                    $query->whereEqual('faculty_id')
                        ->whereEqual('academic_group_id')
                        ->whereEqual('semester_id')
                        ->with('semester', function ($query) {
                            $query->whereEqual('edu_plan_id')
                                ->whereEqual('academic_year_id')
                                ->with('academic_year');
                        })->with('academic_group');
                })->with('exam_schedule_subject', function ($query) {
                    $query->with('subject');
                });
        });
        return $this->successResponse(AcademicDebtAppropriationResource::collection($result));
    }
}
