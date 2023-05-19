<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\SemesterSelectByEduPlanResource;
use App\Http\Resources\SelectData\SemesterSelectResource;
use App\Repository\SelectData\SemesterRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Models\Additional\Reference;
use App\Traits\ApiResponse;

class SemesterService
{
    use ApiResponse;

    public $repository;

    public function __construct(SemesterRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): SemesterService
    {
        return new static(SemesterRepository::getInstance());
    }


    public function getSemesterList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
                'academic_year_id' => ['integer', 'exists:academic_years,id']
            ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors());

        /** O'quv rejasi va o'quv yili bo'yicha filter mavjud;  */
        $result = $this->repository->getDataList(function (Builder $builder) use ($request) {
            return $builder->when($request->edu_plan_id, function ($query) {
                $query->where('edu_plan_id', request('edu_plan_id'));
            })->when($request->academic_year_id, function ($query) {
                $query->where('academic_year_id', request('academic_year_id'));
            })
                ->with(['academic_year'])
                ->orderBy('semester');
        });

        return $this->successResponse(
            SemesterSelectResource::collection(
                $result
            )
        );
    }


    public function getSemesterTypeList()
    {
        return $this->successResponse(
            Reference::where('table_name', 'semester-types')
                ->where('status', true)->get()
        );
    }
}
