<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\EduPlanSelectResource;
use App\Repository\SelectData\EduPlanRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ApiResponse;


class EduPlanService
{
    use ApiResponse;

    public $repository;

    public function __construct(EduPlanRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): EduPlanService
    {
        return new static(EduPlanRepository::getInstance());
    }


    public function getEduPlanList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'faculty_id' => ['integer', 'exists:edu_plans,id'],
                'specialty_id' => ['integer', 'exists:specialties,id'],
                'qualification_id' => ['integer', 'exists:qualifications,id'],
                'academic_year_id' => ['integer', 'exists:academic_years,id'],
                'edu_form_id' => ['integer', 'exists:references,id'],
                'rating_system_id' => ['integer', 'exists:rating_systems,id'],
            ]);

        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        /** [fakultet, mutaxasislik, qualificatsiya, o'quv yili, ta'lim shakli, reting] filter*/
        return $this->successResponse(
            EduPlanSelectResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($request) {
                    return $builder
                        ->when($request->faculty_id, function ($query) {
                            $query->where('faculty_id', request('faculty_id'));
                        })->when($request->specialty_id, function ($query) {
                            $query->where('specialty_id', request('specialty_id'));
                        })->when($request->qualification_id, function ($query) {
                            $query->where('qualification_id', request('qualification_id'));
                        })->when($request->academic_year_id, function ($query) {
                            $query->where('academic_year_id', request('academic_year_id'));
                        })->when($request->edu_form_id, function ($query) {
                            $query->where('edu_form_id', request('edu_form_id'));
                        })->when($request->rating_system_id, function ($query) {
                            $query->where('rating_system_id', request('rating_system_id'));
                        })
                        ->with(['academic_year']);
                })
            )
        );
    }
}