<?php

namespace App\Services\Report;

use App\Http\Resources\Report\AcademicGroupExamsReportResource;
use App\Http\Requests\Report\ActiveStudentReportFilterRequest;
use App\Http\Requests\Report\ActiveTeacherReportFilterRequest;
use App\Http\Requests\Report\AudienceTopicReportFilterRequest;
use App\Http\Requests\Report\TeacherTopicReportFilterRequest;
use App\Http\Resources\Report\ActiveTeachersReportResource;
use App\Http\Resources\Report\ActiveStudentsReportResource;
use App\Http\Resources\Report\AudienceTopicReportResource;
use App\Http\Requests\Report\ResourceReportFilterRequest;
use App\Http\Requests\Report\AudienceReportFilterRequest;
use App\Http\Resources\Report\TeacherTopicReportResource;
use App\Http\Requests\Report\TeacherReportFilterRequest;
use App\Http\Requests\Report\ExamReportFilterRequest;
use App\Http\Resources\Report\AudienceReportResource;
use App\Http\Resources\Report\ResourceReportResource;
use App\Http\Resources\Report\TeacherReportResource;
use App\Filters\Report\ActiveStudentReportFilter;
use App\Filters\Report\ActiveTeacherReportFilter;
use App\Models\Additional\Translate;
use App\Repository\Report\ReportRepository;
use App\Models\Lesson\LessonScheduleTopic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;
use App\Traits\HasTranslations;

class ReportService
{
    use ApiResponse, HasTranslations;

    public $repository;

    public function __construct(ReportRepository $repo)
    {
        $this->repository = $repo;
    }

    public static function getInstance(): ReportService
    {
        return new static(ReportRepository::getInstance());
    }

    public function active_teachers($request)
    {
        $validator = Validator::make($request->all(), ActiveTeacherReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $filter = new ActiveTeacherReportFilter($request);

        $result = $this->repository->action(function (Builder $builder) use ($filter) {
            return $builder->withWhereHas('teacher', function ($query) use ($filter) {
                $query->withWhereHas('work_contract', function ($query) {
                    $query->where('type', 'teacher')
                        ->withWhereHas('department', function ($query) {
                            $query->with('faculty');
                        });
                })->filter($filter);
            });
        });
        return $this->successPaginate(ActiveTeachersReportResource::collection($result));
    }

    public function active_students($request)
    {
        $validator = Validator::make($request->all(), ActiveStudentReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $filter = new ActiveStudentReportFilter($request);

        $result = $this->repository->action(function (Builder $builder) use ($filter) {
            return $builder->withWhereHas('student', function ($query) use ($filter) {
                $query->filter($filter)
                    ->with('specialty', function ($query) {
                        $query->with(['gov_specialty', 'edu_type']);
                    })->with('department');
            });
        });
        return $this->successPaginate(ActiveStudentsReportResource::collection($result));
    }

    public function resources($request)
    {
        $validator = Validator::make($request->all(), ResourceReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->resources(function (Builder $builder) use ($request) {
            return $builder->when($request->department_id, function ($query) {
                $query->whereEqual('department_id');
            })->withWhereHas('department', function ($query) use ($request) {
                $query->when($request->faculty_id, function ($query) {
                    $query->where('department_id', request('faculty_id'));
                })->with(['faculty']);
            })->withWhereHas('curriculum', function ($query) use ($request) {
                $query->withWhereHas('semester', function ($query) use ($request) {
                    $query->when($request->semester_id, function ($query) {
                        $query->where('id', request('semester_id'));
                    })->whereEqual('academic_year_id');
                })->with('edu_plan');
            })
                ->withWhereHas('subject', function ($query) {
                    $query->with('subject_type')
                        ->withCount(['subject_topics', 'subject_topic_resources']);
                })
                ->withCount('subject_tasks');
        });
        return $this->successPaginate(ResourceReportResource::collection($result));
    }

    public function audiences($request)
    {
        $validator = Validator::make($request->all(), AudienceReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->audiences(function (Builder $builder) {
            return $builder->whereEqual('building_id')
                ->withWhereHas('lesson_schedule_topics', function ($query) {
                    $query->whereEqual('week_id')
                        ->select('date', 'pair_id', 'audience_id', DB::raw('count(*)'))
                        ->with(['pair' => function ($query) {
                            $query->where('status', true);
                        }])
                        ->groupBy('date', 'pair_id', 'audience_id');
                })->with('audience_type');
        });

        return $this->successPaginate(AudienceReportResource::collection($result));
    }

    public function audiences_topic($request)
    {
        $validator = Validator::make($request->all(), AudienceTopicReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = LessonScheduleTopic::whereEqual('week_id')
            ->whereEqual('date')
            ->whereEqual('audience_id')
            ->whereEqual('pair_id')
            ->with(['lesson_schedule' => function ($query) {
                $query->with(['academic_group']);
            }, 'subject', 'lesson_activity', 'employee', 'pair', 'audience'])
            ->get();

        return $this->successResponse(AudienceTopicReportResource::collection($result));
    }

    public function teachers($request)
    {
        $validator = Validator::make($request->all(), TeacherReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->teachers(function (Builder $builder) use ($request) {
            return $builder->whereHas('work_contract', function ($query) use ($request) {
                $query->where('type', 'teacher')
                    ->when($request->department_id, function ($query) use ($request) {
                        $query->whereEqual('department_id')
                            ->whereHas('department', function ($query) use ($request) {
                                $query->when($request->faculty_id, function ($query) {
                                    $query->where('department_id', request('faculty_id'));
                                });
                            });
                    });
            })
                ->withWhereHas('lesson_schedule_topics', function ($query) use ($request) {
                    $query->whereEqual('week_id')
                        ->select('date', 'pair_id', 'employee_id', DB::raw('count(*)'))
                        ->with(['pair' => function ($query) {
                            $query->where('status', true);
                        }])
                        ->groupBy('date', 'pair_id', 'employee_id');
                });
        });
        return $this->successPaginate(TeacherReportResource::collection($result));
    }

    public function teachers_topic($request)
    {
        $validator = Validator::make($request->all(), TeacherTopicReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = LessonScheduleTopic::whereEqual('week_id')
            ->whereEqual('date')
            ->whereEqual('employee_id')
            ->whereEqual('pair_id')
            ->with(['lesson_schedule' => function ($query) {
                $query->with(['academic_group']);
            }, 'subject', 'lesson_activity', 'employee', 'pair'])
            ->get();

        return $this->successResponse(TeacherTopicReportResource::collection($result));
    }

    public function exams($request)
    {
        $validator = Validator::make($request->all(), ExamReportFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->exams(function (Builder $builder)  use ($request) {
            return $builder
                ->whereHas('exam', function ($query) use ($request){
                    $query
                        ->whereHas('subject', function ($query) use ($request){
                            $query->when($request->text, function($query){
                                $query->where(function($query){
                                    $query->orWhere('name', 'ilike', '%' . request('text') . '%')
                                    ->orWhereHas('getTranslations', function ($query) {
                                        $query->where('field_value', 'ilike', '%' . request('text') . '%');
                                    });
                                });
                            });
                        })
                        ->whereHas('employee', function ($query) use ($request) {
                            $query->when($request->text, function($query){
                                $query->where(function($query){
                                    $query->orWhere('name', 'ilike', '%' . request('text') . '%');
                                });
                            });
                        })
                        ->whereEqual('academic_year_id')
                        ->whereEqual('semester_id');
                })
                ->with(['academic_group.edu_plan']);
        });


        return $this->successPaginate(AcademicGroupExamsReportResource::collection($result));
    }
}
