<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\ReferenceResource;
use App\Repository\SelectData\ReferenceRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;


class ReferenceService
{
    use ApiResponse;

    public $repository;

    public function __construct(ReferenceRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): ReferenceService
    {
        return new static(ReferenceRepository::getInstance());
    }


    public function getReferenceDataList($table_name, $request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            ]);

        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        /** Filter mavjud emas; */
        return $this->successResponse(
            ReferenceResource::collection(
                $this->repository->getDataList(
                    $table_name,
                    function (Builder $builder) use ($request) {
                        return $builder;
                    }
                )
            )
        );
    }
}