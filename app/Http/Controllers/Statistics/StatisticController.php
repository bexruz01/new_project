<?php

namespace App\Http\Controllers\Statistics;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\AppropriationStatisticFilterRequest;
use App\Http\Requests\Statistics\ContractStatisticFilterRequest;
use App\Http\Requests\Statistics\SocialStatisticFilterRequest;
use App\Http\Requests\Statistics\TrainingStatisticFilterRequest;
use App\Services\Statistics\StatisticService;

class StatisticController extends Controller
{
    use ApiResponse;

    /**************************************************************************************/

    public function general(Request $request)
    {
        return StatisticService::getInstance()->general($request);
    }

    /**************************************************************************************/

    public function student_course(Request $request)
    {
        return StatisticService::getInstance()->student_course($request);
    }

    public function student_specialty(Request $request)
    {
        return StatisticService::getInstance()->student_specialty($request);
    }

    public function student_nation(Request $request)
    {
        return StatisticService::getInstance()->student_nation($request);
    }

    public function student_location(Request $request)
    {
        return StatisticService::getInstance()->student_location($request);
    }

    /**************************************************************************************/

    public function student_social(SocialStatisticFilterRequest $request)
    {
        return StatisticService::getInstance()->student_social($request);
    }

    public function student_social_course(SocialStatisticFilterRequest $request)
    {
        return StatisticService::getInstance()->student_social_course($request);
    }

    /**************************************************************************************/

    public function student_category(Request $request)
    {
        return StatisticService::getInstance()->student_category($request);
    }

    /**************************************************************************************/

    public function academic_degree(Request $request)
    {
        return StatisticService::getInstance()->academic_degree($request);
    }

    public function academic_title(Request $request)
    {
        return StatisticService::getInstance()->academic_title($request);
    }

    public function position(Request $request)
    {
        return StatisticService::getInstance()->position($request);
    }

    public function work_form(Request $request)
    {
        return StatisticService::getInstance()->work_form($request);
    }

    /**************************************************************************************/

    public function resources(Request $request)
    {
        if ($request->grouping_type == 'edu_plan')
            return StatisticService::getInstance()->edu_plan_resource($request);
        else
            return StatisticService::getInstance()->subject_resource($request);
    }

    /**************************************************************************************/

    public function contract(ContractStatisticFilterRequest $request)
    {
        return StatisticService::getInstance()->contract($request);
    }

    /**************************************************************************************/

    public function employment(Request $request)
    {
        return StatisticService::getInstance()->employment($request);
    }

    /**************************************************************************************/

    public function appropriation(AppropriationStatisticFilterRequest $request)
    {
        return StatisticService::getInstance()->appropriation($request);
    }

    /**************************************************************************************/

    public function training(TrainingStatisticFilterRequest $request)
    {
        return StatisticService::getInstance()->training($request);
    }

    /*******************New tasks************ */
    // public function admission_faculty(Request $request)
    // {
    //     return StatisticService::getInstance()->admission_faculty($request);
    // }

    // public function admission_region(Request $request)
    // {
    //     return StatisticService::getInstance()->admission_region($request);
    // }

    public function employees(Request $request)
    {
        return StatisticService::getInstance()->employees($request);
    }
}