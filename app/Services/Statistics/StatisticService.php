<?php

namespace App\Services\Statistics;

use App\Http\Resources\Statistics\GeneralStudent\StudentSpecialtyGeneralStatisticResource;
use App\Http\Resources\Statistics\GeneralStudent\StudentCourseGeneralStatisticResource;
use App\Http\Resources\Statistics\GeneralStudent\StudentNationGeneralStatisticResource;
use App\Http\Resources\Statistics\GeneralStudent\StudentRegionGeneralStatisticResource;
use App\Http\Resources\Statistics\StudentSocialCourseStatisticResource;
use App\Http\Resources\Statistics\EduPlanResourcesStatisticResource;
use App\Http\Resources\Statistics\SubjectResourcesStatisticResource;
use App\Http\Resources\Statistics\AcademicDegreesStatisticResource;
use App\Http\Requests\Statistics\EmploymentStatisticFilterRequest;
use App\Http\Resources\Statistics\AcademicTitlesStatisticResource;
use App\Http\Resources\Statistics\StudentSocialStatisticResource;
use App\Http\Requests\Statistics\GeneralStatisticFilterRequest;
use App\Http\Resources\Statistics\WorkFormsStatisticResource;
use App\Http\Resources\Statistics\PositionsStatisticResource;
use App\Http\Resources\Statistics\ContractStatisticResource;
use App\Http\Resources\Statistics\TrainingStatisticResource;
use App\Http\Resources\Statistics\GeneralStatisticResource;
use App\Http\Resources\Statistics\StudentCategoryResource;
use App\Http\Resources\Statistics\AppropriationResource;
use App\Repository\Statistics\StatisticRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Filters\Students\StudentsFilter;
use App\Models\Additional\Department;
use App\Models\Additional\Specialty;
use Illuminate\Support\Facades\DB;
use App\Models\User\Employee;
use App\Traits\ApiResponse;


class StatisticService
{
    use ApiResponse;

    public $repository;

    public function __construct(StatisticRepository $repo)
    {
        $this->repository = $repo;
    }

    public static function getInstance(): StatisticService
    {
        return new static(StatisticRepository::getInstance());
    }

    public function general($request)
    {
        $validator = Validator::make($request->all(), GeneralStatisticFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->student(function (Builder $builder) {
            return $builder
                ->whereEqual('faculty_id')
                ->whereEqual('specialty_id')
                ->whereHas('semester', function ($query) {
                    $query->where('academic_year_id', currentAcademicYear()->id);
                })
                ->with('semester');
        });

        $result = [
            'faculty' => Department::find($request->faculty_id),
            'specialty' => Specialty::find($request->specialty_id),
            'students' => $result,
        ];

        return $this->successResponse(
            new GeneralStatisticResource($result)
        );
    }

    public function student_course($request)
    {
        $query = DB::table('students')
            ->select('course', 'gender', 'payment_type_id', DB::raw('COUNT(*)'))
            ->leftjoin('academic_groups', 'academic_groups.id', '=', 'students.academic_group_id')
            ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
            ->leftJoin('specialties', 'specialties.id', '=', 'students.specialty_id')
            ->leftjoin('edu_plans', 'edu_plans.id', '=', 'academic_groups.edu_plan_id');
        if ($request->get('faculty_id', false))
            $query = $query->where('students.faculty_id', $request->get('faculty_id'));

        if ($request->get('semester_id', false))
            $query = $query->where('semester_id', $request->get('semester_id'));

        if ($request->get('edu_type_id', false))
            $query = $query->where('specialties.edu_type_id', $request->get('edu_type_id'));

        if ($request->get('edu_plan_id', false))
            $query = $query->where('edu_plan_id', $request->get('edu_plan_id'));

        if ($request->get('edu_form_id', false))
            $query = $query->where('edu_form_id', $request->get('edu_form_id'));

        if ($request->get('specialty_id', false))
            $query = $query->where('specialty_id', $request->get('specialty_id'));

        $result['list'] = $query->groupBy('course', 'gender', 'payment_type_id')->get();

        return $this->successResponse(
            new StudentCourseGeneralStatisticResource($result)
        );
    }

    public function student_specialty($request)
    {
        $query = DB::table('students')
            ->select('students.specialty_id', 'gender', 'payment_type_id', DB::raw('COUNT(*)'))
            ->leftjoin('academic_groups', 'academic_groups.id', '=', 'students.academic_group_id')
            ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
            ->leftJoin('specialties', 'specialties.id', '=', 'students.specialty_id')
            ->leftjoin('edu_plans', 'edu_plans.id', '=', 'academic_groups.edu_plan_id');

        if ($request->get('faculty_id', false))
            $query = $query->where('students.faculty_id', $request->get('faculty_id'));

        if ($request->get('semester_id', false))
            $query = $query->where('semester_id', $request->get('semester_id'));

        if ($request->get('edu_type_id', false))
            $query = $query->where('specialties.edu_type_id', $request->get('edu_type_id'));

        if ($request->get('edu_plan_id', false))
            $query = $query->where('edu_plan_id', $request->get('edu_plan_id'));

        if ($request->get('edu_form_id', false))
            $query = $query->where('edu_form_id', $request->get('edu_form_id'));

        if ($request->get('specialty_id', false))
            $query = $query->where('specialty_id', $request->get('specialty_id'));

        $result['list'] = $query->groupBy('students.specialty_id', 'gender', 'payment_type_id')->get();

        return $this->successResponse(
            new StudentSpecialtyGeneralStatisticResource($result)
        );
    }

    public function student_nation($request)
    {
        $query = DB::table('students')
            ->select('course', 'nation_id', 'gender', 'payment_type_id', DB::raw('COUNT(*)'))
            ->leftjoin('academic_groups', 'academic_groups.id', '=', 'students.academic_group_id')
            ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
            ->leftJoin('specialties', 'specialties.id', '=', 'students.specialty_id')
            ->leftjoin('edu_plans', 'edu_plans.id', '=', 'academic_groups.edu_plan_id');

        if ($request->get('faculty_id', false))
            $query = $query->where('students.faculty_id', $request->get('faculty_id'));

        if ($request->get('semester_id', false))
            $query = $query->where('semester_id', $request->get('semester_id'));

        if ($request->get('edu_type_id', false))
            $query = $query->where('specialties.edu_type_id', $request->get('edu_type_id'));

        if ($request->get('edu_plan_id', false))
            $query = $query->where('edu_plan_id', $request->get('edu_plan_id'));

        if ($request->get('edu_form_id', false))
            $query = $query->where('edu_form_id', $request->get('edu_form_id'));

        if ($request->get('specialty_id', false))
            $query = $query->where('specialty_id', $request->get('specialty_id'));

        $result['list'] = $query->groupBy('course', 'nation_id', 'gender', 'payment_type_id')->get();

        return $this->successResponse(
            new StudentNationGeneralStatisticResource($result)
        );
    }

    public function student_location($request)
    {
        $query = DB::table('students')
            ->select('course', 'region_id', 'gender', 'payment_type_id', DB::raw('COUNT(*)'))
            ->leftjoin('academic_groups', 'academic_groups.id', '=', 'students.academic_group_id')
            ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
            ->leftJoin('specialties', 'specialties.id', '=', 'students.specialty_id')
            ->leftjoin('edu_plans', 'edu_plans.id', '=', 'academic_groups.edu_plan_id');

        if ($request->get('faculty_id', false)) {
            $query = $query->where('students.faculty_id', $request->get('faculty_id'));
        }
        if ($request->get('semester_id', false)) {
            $query = $query->where('semester_id', $request->get('semester_id'));
        }
        if ($request->get('edu_type_id', false)) {
            $query = $query->where('specialties.edu_type_id', $request->get('edu_type_id'));
        }
        if ($request->get('edu_plan_id', false)) {
            $query = $query->where('edu_plan_id', $request->get('edu_plan_id'));
        }
        if ($request->get('edu_form_id', false)) {
            $query = $query->where('edu_form_id', $request->get('edu_form_id'));
        }
        if ($request->get('specialty_id', false)) {
            $query = $query->where('specialty_id', $request->get('specialty_id'));
        }

        $result['list'] = $query->groupBy('course', 'region_id', 'gender', 'payment_type_id')->get();

        return $this->successResponse(
            new StudentRegionGeneralStatisticResource($result)
        );
    }

    public function student_social($request)
    {
        $result = Department::where('type', 'faculty')
            ->withWhereHas('students', function ($query) use ($request) {
                $query->whereHas('semester', function ($query) use ($request) {
                    $query->whereEqual('academic_year_id')
                        ->when($request->semester_type, function ($query) {
                            $query->whereRaw('semester%2=' . request('semester_type'));
                        });
                })
                    ->select('faculty_id', 'social_category_id', DB::raw('count(*)'))
                    ->groupBy('social_category_id', 'faculty_id')
                    ->orderBy('social_category_id', 'DESC');
            })->get();
        return $this->successResponse(
            StudentSocialStatisticResource::collection($result)
        );
    }

    public function student_social_course($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->withWhereHas('students', function ($query) use ($request) {
                $query->whereHas('semester', function ($query) use ($request) {
                    $query->whereEqual('academic_year_id')
                        ->when($request->semester_type, function ($query) {
                            $query->whereRaw('semester%2=' . request('semester_type'));
                        });
                })
                    ->withWhereHas('academic_group', function ($query) {
                        $query->with('edu_plan');
                    });
            });
        });
        return $this->successResponse(
            StudentSocialCourseStatisticResource::collection($result)
        );
    }

    public function student_category($request)
    {
        $result = $this->repository->student(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('faculty_id', request('faculty_id'));
            })->when($request->social_category_id, function ($query) {
                $query->where('social_category_id', request('social_category_id'));
            })->withWhereHas('semester', function ($query) use ($request) {
                $query->when($request->academic_year_id, function ($query) {
                    $query->where('academic_year_id', request('academic_year_id'));
                });
            })->withWhereHas('specialty', function ($query) {
                $query->with('edu_type');
            })->withWhereHas('academic_group', function ($query) {
                $query->withWhereHas('edu_plan', function ($query) {
                    $query->with('edu_form');
                });
            })->with(['social_category', 'department']);
        });
        return $this->successPaginate(
            StudentCategoryResource::collection($result)
        );
    }

    public function academic_degree($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('id', request('faculty_id'));
            })->withWhereHas('departments', function ($query) {
                $query->with('employees');
            });
        });
        return $this->successResponse(
            AcademicDegreesStatisticResource::collection($result)
        );
    }

    public function academic_title($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('id', request('faculty_id'));
            })->withWhereHas('departments', function ($query) {
                $query->with('employees');
            });
        });
        return $this->successResponse(
            AcademicTitlesStatisticResource::collection($result)
        );
    }

    public function position($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('id', request('faculty_id'));
            })->withWhereHas('departments', function ($query) {
                $query->withWhereHas('employees', function ($query) {
                    $query->with('work_contract');
                });
            });
        });
        return $this->successResponse(
            PositionsStatisticResource::collection($result)
        );
    }

    public function work_form($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('id', request('faculty_id'));
            })->withWhereHas('departments', function ($query) {
                $query->withWhereHas('employees', function ($query) {
                    $query->with('work_contract');
                });
            });
        });
        return $this->successResponse(
            WorkFormsStatisticResource::collection($result)
        );
    }


    public function subject_resource($request)
    {
        $result = $this->repository->curriculum_subject(function (Builder $builder) use ($request) {
            return $builder->whereEqual('department_id')
                ->whereEqual('subject_id')
                ->withWhereHas('curriculum', function ($query) {
                    $query->whereEqual('edu_plan_id')
                        ->whereEqual('semester_id')
                        ->with(['edu_plan', 'semester']);
                })
                ->withWhereHas('subject', function ($query) use ($request) {
                    $query->withCount(['subject_topic_resources' => function ($query) use ($request) {
                        $query->when($request->language_id, function ($query) {
                            $query->whereEqual('language_id');
                        });
                    }]);
                });
        });
        return $this->successPaginate(
            SubjectResourcesStatisticResource::collection($result)
        );
    }

    public function edu_plan_resource($request)
    {
        $result = $this->repository->edu_plan(function (Builder $builder) use ($request) {
            return $builder->when($request->edu_plan_id, function ($query) {
                $query->where('id', request('edu_plan_id'));
            })->withWhereHas('curriculums', function ($query) use ($request) {
                $query->when($request->semester_id, function ($query) {
                    $query->whereEqual('semester_id');
                })->withWhereHas('curriculum_subjects', function ($query) use ($request) {
                    $query->when($request->department_id, function ($query) {
                        $query->whereEqual('department_id');
                    })->withWhereHas('subject', function ($query) use ($request) {
                        $query->withCount(['subject_topic_resources' => function ($query) use ($request) {
                            $query->when($request->language_id, function ($query) use ($request) {
                                $query->where('language_id', $request->language_id);
                            });
                        }]);
                    });
                });
            })->when($request->faculty_id, function ($query) {
                $query->whereEqual('faculty_id');
            })->with(['faculty']);
        });
        return $this->successPaginate(
            EduPlanResourcesStatisticResource::collection($result)
        );
    }

    public function contract($request)
    {
        $result = $this->repository->faculty(function (Builder $builder) use ($request) {
            return $builder->when($request->faculty_id, function ($query) {
                $query->where('id', request('faculty_id'));
            })->with('students', function ($query) use ($request) {
                $query->with('academic_group.edu_plan')
                    ->withWhereHas('semester', function ($query) use ($request) {
                        $query
                            ->when($request->semester_type, function ($query) {
                                $query->whereRaw('semester%2=' . request('semester_type'));
                            })
                            ->when($request->academic_year_id, function ($query) {
                                $query->whereEqual('academic_year_id');
                            });
                    })
                    ->withWhereHas('specialty', function ($query) use ($request) {
                        $query->when($request->edu_type_id, function ($query) {
                            $query->whereEqual('edu_type_id');
                        });
                    })
                    ->with('student_contract');
            });
        });
        return $this->successResponse(
            ContractStatisticResource::collection($result)
        );
    }

    public function employment($request)
    {
        $validator = Validator::make($request->all(), EmploymentStatisticFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->getMessageBag());

        $result = 'Jadvalni aniqlashtirish kerak !!!';
        return $this->successResponse($result);
    }

    public function appropriation($request)
    {
        $filter = new StudentsFilter($request);
        $result = $this->repository->faculty(function (Builder $builder) use ($filter, $request) {
            return $builder
                ->withWhereHas('students', function ($query) use ($filter, $request) {
                    $query->filter($filter)
                        ->whereHas('semester', function ($query) use ($request) {
                            $query->when($request->semester_type, function ($query) {
                                $query->whereRaw('semester%2=' . request('semester_type'));
                            });
                        })
                        ->withCount('exam_schedule_results')
                        ->with('exam_schedule_results');
                });
        });
        return $this->successResponse(
            AppropriationResource::collection($result)
        );
    }

    public function training($request)
    {
        $result = $this->repository->training(function (Builder $builder) {
            return $builder
                ->with(['subject'])
                ->withWhereHas('curriculum_audiance_hourses', function ($query) {
                    $query->with('lesson_activity');
                })
                ->withWhereHas('lesson_schedule_topics', function ($query) {
                    $query->withWhereHas('lesson_schedule', function ($query) {
                        $query->whereEqual('semester_id')
                            ->whereEqual('academic_group_id')
                            ->whereHas('semester', function ($query) {
                                $query->whereEqual('academic_year_id');
                            })
                            ->whereHas('academic_group', function ($query) {
                                $query->whereEqual('edu_plan_id');
                            });
                    })->with('lesson_activity');
                });
        });
        return $this->successResponse(
            TrainingStatisticResource::collection($result)
        );
    }

    //--------------New Tasks----------------------------

    // public function admission_faculty($request)
    // {
    //     $result = Student::when($request->academic_year, function ($query) {
    //         $query->where('date_start', request('academic_year'));
    //     })
    //         ->select(
    //             'date_start',
    //             'faculty_id',
    //             DB::raw('count(*) as student_count')
    //         )
    //         ->with(['faculty:id,name'])
    //         ->groupBy('date_start', 'faculty_id')
    //         ->orderBy('date_start', 'DESC')
    //         ->get();
    //     return $result;
    // }

    // public function admission_region($request)
    // {
    //     $result = Student::when($request->academic_year, function ($query) {
    //         $query->where('date_start', request('academic_year'));
    //     })
    //         ->select(
    //             'date_start',
    //             'region_id',
    //             DB::raw('count(*) as student_count')
    //         )
    //         ->with(['region:id,name'])
    //         ->groupBy('date_start', 'region_id')
    //         ->orderBy('date_start', 'DESC')
    //         ->get();
    //     return $result;
    // }

    public function employees($request)
    {
        $result = Employee::all();
        return $result;
    }
}
