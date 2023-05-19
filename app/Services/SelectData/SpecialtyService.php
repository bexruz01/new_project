<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\SpecialtyResource;
use App\Repository\SelectData\SpecialtyRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;


class SpecialtyService
{
    use ApiResponse;

    public $repository;

    public function __construct(SpecialtyRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): SpecialtyService
    {
        return new static(SpecialtyRepository::getInstance());
    }


    public function getSpecialtyList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'faculty_id' => ['integer', 'exists:departments,id'],
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
            ]);

        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        $result = $this->repository->getSpecialtyList(function (Builder $builder) {
            return $builder->with(['gov_specialty'])
                ->whereEqual('faculty_id')
                ->whereEqual('edu_type_id');
        });

        return $this->successResponse(
            SpecialtyResource::collection(
                $result
            )
        );
    }
}