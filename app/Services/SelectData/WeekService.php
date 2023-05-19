<?php

namespace App\Services\SelectData;

use App\Http\Resources\SelectData\WeekResource;
use App\Repository\SelectData\WeekRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Academic\AcademicYear;
use App\Traits\ApiResponse;

class WeekService
{
    use ApiResponse;

    public $repository;

    public function __construct(WeekRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): WeekService
    {
        return new static(WeekRepository::getInstance());
    }


    public function getWeekList($request)
    {
        $validator =
            Validator::make($request->all(), [
                'edu_plan_id' => ['integer', 'exists:edu_plans,id'],
                'semester_id' => ['integer', 'exists:semesters,id'],
                'week_type_id' => ['integer', 'exists:references,id'],
            ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors());

        $result = AcademicYear::where('is_current', true)
            ->withWhereHas('edu_plans', function($query){
                $query->where('status', true);
            })
            ->first();

            // return $result;
        $result = $this->maxAndMinValues($result->semester, $result->edu_plans);

        return $this->successResponse(
            WeekResource::collection(
                $this->repository->getDataList(function (Builder $builder) use ($result) {
                    return $builder
                        ->whereHas('lessons')
                        ->where('date_start', '>', $result['min'])
                        ->where('date_end', '<', $result['max'])
                        ->orderBy('date_start', 'ASC');
                })
            )
        );
    }

    public function maxAndMinValues($semester, $list)
    {
        $i = 0;
        $max = 0;
        $min = 0;
        foreach ($list as $item) {
            if ($i == 0) {
                if ($semester == 1) {
                    $min = $item->autumn_start;
                    $max = $item->autumn_end;
                } else {
                    $min = $item->spring_start;
                    $max = $item->spring_end;
                }
                $i++;
            } else {
                if ($semester == 1) {
                    if ($item->autumn_start < $min) {
                        $min = $item->autumn_start;
                    }
                    if ($item->autumn_end > $max) {
                        $max = $item->autumn_end;
                    }
                } else {
                    if ($item->spring_start < $min) {
                        $min = $item->spring_start;
                    }
                    if ($item->spring_end > $max) {
                        $max = $item->spring_end;
                    }
                }
            }
        }
        return [
            'min' => $min,
            'max' => $max,
        ];
    }
}
