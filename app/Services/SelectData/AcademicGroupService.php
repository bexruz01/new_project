<?php

namespace App\Services\SelectData;

use App\Repository\SelectData\AcademicGroupRepository;
use App\Http\Resources\SelectData\SelectDataResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;


class AcademicGroupService
{
    use ApiResponse;

    public $repository;

    public function __construct(AcademicGroupRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): AcademicGroupService
    {
        return new static(AcademicGroupRepository::getInstance());
    }


    public function getAcademicGroupList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
                'language_id' => ['integer', 'exists:references,id']
            ]);

        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        /** O'quv rejasi va ta'lim tili bo'yicha filter mavjud;  */
        return $this->successResponse(
            SelectDataResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($request) {
                    return $builder->when($request->edu_plan_id, function ($query) {
                        $query->where('edu_plan_id', request('edu_plan_id'));
                    })->when($request->language_id, function ($query) {
                        $query->where('language_id', request('language_id'));
                    });
                })
            )
        );
    }
}