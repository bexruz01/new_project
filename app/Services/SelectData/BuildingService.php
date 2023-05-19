<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\BuildingResource;
use App\Repository\SelectData\BuildingRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;


class BuildingService
{
    use ApiResponse;

    public $repository;

    public function __construct(BuildingRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): BuildingService
    {
        return new static(BuildingRepository::getInstance());
    }


    public function getBuildingList($request)
    {
        /** Filter mavjud emas!!! */
        return $this->successResponse(
            BuildingResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($request) {
                    return $builder;
                })
            )
        );
    }
}