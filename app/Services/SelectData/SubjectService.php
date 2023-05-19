<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\SelectDataResource;
use App\Repository\SelectData\SubjectRepository;
use App\Traits\ApiResponse;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class SubjectService
{
    use ApiResponse;

    public $repository;

    public function __construct(SubjectRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): SubjectService
    {
        return new static(SubjectRepository::getInstance());
    }


    public function getSubjectList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_type_id' => ['integer', 'exists:references,id'],
                'subject_group_id' => ['integer', 'exists:subject_groups,id'],
                'subject_type_id' => ['integer', 'exists:references,id'],
            ]);

        if ($validator->fails())
            return $this->errorResponse(__('message.Not found'));

        /** O'quv rejasi va o'quv yili bo'yicha filter mavjud;  */
        return $this->successResponse(
            SelectDataResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($request) {
                    return $builder->when($request->edu_type_id, function ($query) {
                        $query->where('edu_type_id', request('edu_type_id'));
                    })->when($request->subject_group_id, function ($query) {
                        $query->where('subject_group_id', request('subject_group_id'));
                    })->when($request->subject_type_id, function ($query) {
                        $query->where('subject_type_id', request('subject_type_id'));
                    });
                })
            )
        );
    }
}