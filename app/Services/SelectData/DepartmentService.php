<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\DepartmentResource;
use App\Repository\SelectData\DepartmentRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;

class DepartmentService
{
    use ApiResponse;

    public $repository;

    public function __construct(DepartmentRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): DepartmentService
    {
        return new static(DepartmentRepository::getInstance());
    }


    public function getDepartmentDataList($type, $request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            ]);
        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        /** Filter mavjud emas! */
        return $this->successResponse(
            DepartmentResource::collection(
                $this->repository->getDataList(
                    $type,
                    function (Builder $builder) use ($request) {
                        return $builder;
                    }
                )
            )
        );
    }
}