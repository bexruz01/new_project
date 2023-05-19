<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\LessonActivityResource;
use App\Repository\SelectData\AcademicTrainingRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;

class AcademicTrainingService
{
    use ApiResponse;

    public $repository;

    public function __construct(AcademicTrainingRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): AcademicTrainingService
    {
        return new static(AcademicTrainingRepository::getInstance());
    }


    public function getAcademicTrainingList($request)
    {

        /** Filter mavjud emas!!! */
        return $this->successResponse(
            LessonActivityResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($request) {
                    return $builder;
                })
            )
        );
    }
}