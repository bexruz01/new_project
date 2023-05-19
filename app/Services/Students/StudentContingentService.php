<?php

namespace App\Services\Students;

use App\Repository\Students\StudentContingentRepository;
use App\Http\Resources\Students\StudentResource;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Students\StudentsFilter;
use App\Traits\ApiResponse;


class StudentContingentService
{
    use ApiResponse;

    protected $repository;

    public function __construct(StudentContingentRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): StudentContingentService
    {
        return new static(StudentContingentRepository::getInstance());
    }

    public function students($request)
    {
        $filter = new StudentsFilter($request);

        $result = $this->repository->getData(function (Builder $builder) use ($filter) {
            return $builder->filter($filter)
                ->with([
                    'academic_group.edu_plan.edu_form',
                    'region',
                    'district',
                    'live_place',
                    'payment_type'
                ])
                ->with('specialty', function ($query) {
                    $query->with(['type', 'edu_type', 'gov_specialty']);
                });
        });
        return $this->successPaginate(StudentResource::collection($result));
    }
}