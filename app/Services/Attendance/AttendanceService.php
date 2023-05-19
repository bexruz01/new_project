<?php

namespace App\Services\Attendance;

use App\Http\Requests\Attendance\FacultyAttendanceFilterRequest;
use App\Http\Resources\Attendance\StatisticAttendancesResource;
use App\Http\Requests\Attendance\LessonAttendanceFilterRequest;
use App\Http\Requests\Attendance\GroupAttendanceFilterRequest;
use App\Http\Resources\Attendance\EmployeeAttendancesResource;
use App\Http\Requests\Attendance\PairAttendanceFilterRequest;
use App\Http\Resources\Attendance\FacultyAttendancesResource;
use App\Http\Resources\Attendance\StudentAttendancesResource;
use App\Http\Resources\Attendance\SubjectAttendancesResource;
use App\Http\Resources\Attendance\LessonAttendancesResource;
use App\Http\Resources\Attendance\GroupAttendancesResource;
use App\Http\Resources\Attendance\PairAttendancesResource;
use App\Repository\Attendance\AttendanceRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;
use stdClass;

class AttendanceService
{
    use ApiResponse;

    protected $repository;

    public function __construct(AttendanceRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): AttendanceService
    {
        return new static(AttendanceRepository::getInstance());
    }

    public function report($request)
    {
        $result = $this->repository->report(function (Builder $builder) {
            return $builder->select(
                'student_id',
                'lesson_schedule_topic_id',
                DB::raw('COUNT(CASE WHEN status_id = True THEN 1 END) AS because_of'),
                DB::raw('COUNT(CASE WHEN status_id is null or status_id=False THEN 1 END) AS not_because_of'),
                DB::raw('count(*) as total_nb'),
            )
                ->withWhereHas('student', function ($query) {
                    $query->whereEqual('academic_group_id')
                        ->whereEqual('faculty_id')
                        ->whereEqual('semester_id')
                        ->withWhereHas('academic_group', function ($query) {
                            $query->whereEqual('edu_plan_id')
                                ->whereHas('edu_plan', function ($query) {
                                    $query->whereEqual('edu_form_id');
                                });
                        })
                        ->withWhereHas('specialty', function ($query) {
                            $query->whereEqual('edu_type_id');
                        });
                })
                ->withWhereHas('lesson_schedule_topic', function ($query) {
                    $query->whereEqual('subject_id')
                        ->with(['subject', 'subject_topic', 'audience']);
                })
                ->groupBy(['student_id', 'lesson_schedule_topic_id']);
        });

        return $this->successPaginate(
            StudentAttendancesResource::collection($result)
        );
    }

    public function statistic($request)
    {
        $result = $this->repository->report(function (Builder $builder) use ($request) {
            return $builder->select(
                'student_id',
                DB::raw('COUNT(CASE WHEN status_id = True THEN 1 END) AS because_of'),
                DB::raw('COUNT(CASE WHEN status_id is null or status_id=False THEN 1 END) AS not_because_of'),
                DB::raw('count(*) as total_nb'),
            )->withWhereHas('student', function ($query) use ($request) {
                $query->whereEqual('faculty_id')
                    ->withWhereHas('academic_group', function ($query) {
                        $query->whereHas('edu_plan', function ($query) {
                            $query->whereEqual('edu_form_id');
                        });
                    })
                    ->withWhereHas('specialty', function ($query) {
                        $query->whereEqual('edu_type_id')
                            ->with(['edu_type', 'gov_specialty']);
                    })
                    ->withWhereHas('semester', function ($query) use ($request) {
                        $query->whereEqual('academic_year_id')
                            ->when($request->semester_type_id, function ($query) {
                                $i = request('semester_type_id');
                                $query->whereIn('semester', [$i, $i + 2, $i + 4, $i + 6]);
                            });
                    });
            })->groupBy(['student_id']);
        });
        return $this->successPaginate(StatisticAttendancesResource::collection($result));
    }

    public function subject($request)
    {
        return $this->repository->subject(function (Builder $builder) use ($request) {
            return $builder
                ->where('id', $request->academic_group_id)
                ->when(request('edu_plan_id'), function ($query) {
                    $query->where('edu_plan_id', request('edu_plan_id'));
                    $query->withWhereHas('edu_plan', function ($query) {
                        $query->whereEqual('academic_year_id');
                        $query->whereEqual('edu_form_id');
                    });
                })
                ->withWhereHas('students', function ($query) {
                    $query->whereEqual('semester_id')
                        ->withCount('student_attendances')
                        ->with(['student_attendances' => ['lesson_schedule_topic']]);
                })
                ->with(['subjects']);
        });

        // if (!$result)
        //     return $this->successResponse(new stdClass());

        // return $this->successResponse(new SubjectAttendancesResource($result));
    }

    public function basic($request)
    {
        $result = $this->repository->lesson_schedule_topic(function (Builder $builder) use ($request) {
            return $builder
                ->withWhereHas('employee', function ($query) use ($request) {
                    $query->withWhereHas('work_contract', function ($query) {
                        $query->with('department');
                    })->when($request->text, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where(DB::raw("concat(surname,' ',name,' ',patronymic)"), 'ilike', '%' . $request->text . '%');
                        });
                    });
                })
                ->withWhereHas('lesson_schedule', function ($query) use ($request) {
                    $query->withWhereHas('academic_group', function ($query) use ($request) {
                        $query->withWhereHas('edu_plan', function ($query) use ($request) {
                            $query->when($request->faculty_id, function ($query) use ($request) {
                                $query->where('faculty_id', $request->faculty_id);
                            })->with(['faculty' => function ($query) use ($request) {
                                $query->when($request->text, function ($query) use ($request) {
                                    $query->orWhere('name', 'ilike', '%' . $request->text . '%');
                                });
                            }]);
                        })->when($request->text, function ($query) use ($request) {
                            $query->orWhere('name', 'ilike', '%' . $request->text . '%');
                        });
                    });
                })
                ->with([
                    'subject' => function ($query) use ($request) {
                        $query->when($request->text, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->orWhere('name', 'ilike', '%' . $request->text . '%');
                            });
                        });
                    }, 'lesson_activity', 'pair'
                ])
                ->when($request->date_start, function ($query) {
                    $query->where('date', '>', request('date_start'));
                })->when($request->date_end, function ($query) {
                    $query->where('date', '<', request('date_end'));
                });
        });
        return $this->successPaginate(LessonAttendancesResource::collection($result));
    }

    public function faculty($request)
    {
        $validator = Validator::make($request->all(), FacultyAttendanceFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->withWhereHas('academic_groups', function ($query) use ($request) {
                $query->with(['lesson_topic' => function ($query) use ($request) {
                    $query->when($request->date_start, function ($query) {
                        $query->where('date', '>', request('date_start'));
                    })->when($request->date_end, function ($query) {
                        $query->where('date', '<', request('date_end'));
                    });
                }])
                    ->withWhereHas('edu_plan', function ($query) use ($request) {
                        $query->when($request->faculty_id, function ($query) {
                            $query->where('faculty_id', request('faculty_id'));
                        });
                    });
            })
                ->when($request->text, function ($query) {
                    $query->where('name', 'ilike', '%' . request('text') . '%');
                });
        });
        return $this->successPaginate(FacultyAttendancesResource::collection($result));
    }

    public function group($request)
    {
        $validator = Validator::make($request->all(), GroupAttendanceFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->group(function (Builder $builder) use ($request) {
            return $builder
                ->with(['lesson_topic' => function ($query) use ($request) {
                    $query->when($request->date_start, function ($query) {
                        $query->where('date', '>', request('date_start'));
                    })->when($request->date_end, function ($query) {
                        $query->where('date', '<', request('date_end'));
                    });
                }])
                ->withWhereHas('edu_plan', function ($query) use ($request) {
                    $query->when($request->faculty_id, function ($query) {
                        $query->where('faculty_id', request('faculty_id'));
                    });
                })
                ->when($request->text, function ($query) {
                    $query->where('name', 'ilike', '%' . request('text') . '%');
                });
        });
        return $this->successPaginate(GroupAttendancesResource::collection($result));
    }

    public function pair($request)
    {
        $validator = Validator::make($request->all(), PairAttendanceFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->pair(function (Builder $builder) use ($request) {
            return $builder->when($request->date_start, function ($query) {
                $query->where('date', '>', request('date_start'));
            })->when($request->date_end, function ($query) {
                $query->where('date', '<', request('date_end'));
            })->select(
                'pair_id',
                DB::raw('count(*) as count'),
            )->with('pair')
                ->groupBy('pair_id');
        });
        return $this->successPaginate(PairAttendancesResource::collection($result));
    }

    public function teacher($request)
    {
        $validator = Validator::make($request->all(), PairAttendanceFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse(__('message.Not found'));

        $result = $this->repository->teacher(function (Builder $builder) use ($request) {
            return $builder->when($request->text, function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request->text . '%')
                    ->orWhere('surname', 'ilike', '%' . $request->text . '%')
                    ->orWhere('patronymic', 'ilike', '%' . $request->text . '%');
            })->withWhereHas('work_contract', function ($query) use ($request) {
                $query->where('type', 'teacher')
                    ->whereHas('department', function ($query) use ($request) {
                        $query->when($request->faculty_id, function ($query) {
                            $query->where('department_id', request('faculty_id'));
                        });
                    });
            })->with('lesson_schedule_topics', function ($query) use ($request) {
                $query->when($request->date_start, function ($query) {
                    $query->where('date', '>', request('date_start'));
                })->when($request->date_end, function ($query) {
                    $query->where('date', '<', request('date_end'));
                });
            });
        });
        return $this->successPaginate(EmployeeAttendancesResource::collection($result));
    }
}
