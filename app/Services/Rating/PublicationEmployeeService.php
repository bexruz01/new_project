<?php

namespace App\Services\Rating;

use App\Http\Requests\Rating\DepartmentRatingFilterRequest;
use App\Http\Requests\Rating\FacultyRatingFilterRequest;
use App\Http\Requests\Rating\TeacherRatingFilterRequest;
use App\Repository\Rating\PublicationEmployeeRepository;
use App\Http\Resources\Rating\DepartmentRatingResource;
use App\Http\Resources\Rating\TeachersRatingResource;
use App\Http\Resources\Rating\FacultyRatingResource;
use App\Http\Resources\Rating\TeacherRatingResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class PublicationEmployeeService
{
    use ApiResponse;

    public $repository;

    public function __construct(PublicationEmployeeRepository $repo)
    {
        $this->repository = $repo;
    }

    public static function getInstance(): PublicationEmployeeService
    {
        return new static(PublicationEmployeeRepository::getInstance());
    }


    public function teachers($request)
    {
        $validator = Validator::make($request->all(), TeacherRatingFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->employee(function (Builder $builder) {
            return $builder->whereHas('publication', function ($query) {
                $query->where('academic_year_id', request('academic_year_id'))
                    ->withSum('rating_critery as ball', 'ball');
            })
                ->whereHas('work_contract', function ($query) {
                    $query
                        ->where('type', 'teacher')
                        ->whereHas('department', function ($query) {
                            $query->where('id', request('department_id'))
                                ->where('type', 'department')
                                ->where('department_id', request('faculty_id'));
                        })
                        ->with('getTranslations');
                })
                ->withSum('rating as ball', 'ball');
        });
        return $this->successPaginate(
            TeachersRatingResource::collection($result)
        );
    }


    public function teacher($id)
    {
        $result = $this->repository->publication_employee(function (Builder $builder) use ($id) {
            return $builder
                ->withWhereHas('publication', function ($query) {
                    $query->withWhereHas('rating_critery', function ($query) {
                        $query->with('critery', 'publication_type');
                    });
                })->with('employee')
                ->where('employee_id', $id);
        });
        return $this->successResponse(TeacherRatingResource::collection($result));
    }


    public function department($request)
    {
        $validator = Validator::make($request->all(), DepartmentRatingFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->department(function (Builder $builder) {
            return $builder->with('employees', function ($query) {
                $query->whereHas('publication', function ($query) {
                    $query->where('academic_year_id', request('academic_year_id'));
                })
                    ->withSum('rating as ball', 'ball');
            })
                ->where('department_id', request('faculty_id'));
        });
        return $this->successPaginate(DepartmentRatingResource::collection($result));
    }


    public function faculty($request)
    {
        $validator = Validator::make($request->all(), FacultyRatingFilterRequest::filterValidate());
        if ($validator->fails()) return $this->errorResponse($validator->errors());

        $result = $this->repository->department(function (Builder $builder) {
            return $builder->with('departments', function ($query) {
                $query->with('employees', function ($query) {
                    $query->whereHas('publication', function ($query) {
                        $query->where('academic_year_id', request('academic_year_id'));
                    })
                        ->withSum('rating as ball', 'ball');
                });
            });
        });
        return $this->successPaginate(FacultyRatingResource::collection($result));
    }
}