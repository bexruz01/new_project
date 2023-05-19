<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\AcademicYearSelectResource;
use App\Repository\SelectData\AcademicYearRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;

class AcademicYearService
{
    use ApiResponse;

    public $repository;

    public function __construct(AcademicYearRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): AcademicYearService
    {
        return new static(AcademicYearRepository::getInstance());
    }


    public function getAcademicYearList($request)
    {
        $result = $this->repository->getDataList(function (Builder $builder) use ($request) {
            return $builder->when($request->year, function ($query) {
                $query->where('year', '>=', request('year'));
            })
                ->orderBy('year', 'asc');
        }); 
        return $this->successResponse(
            AcademicYearSelectResource::collection(
                $result
            )
        );
    }
}