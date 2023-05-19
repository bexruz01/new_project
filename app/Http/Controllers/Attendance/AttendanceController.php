<?php

namespace App\Http\Controllers\Attendance;

use App\Services\Attendance\AttendanceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\LessonAttendanceFilterRequest;
use App\Http\Requests\Attendance\ReportAttendanceFilterRequest;
use App\Http\Requests\Attendance\StatisticAttendanceFilterRequest;
use App\Http\Requests\Attendance\SubjectAttendanceFilterRequest;
use App\Http\Resources\Attendance\SubjectAttendancesResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AttendanceController extends Controller
{
    use ApiResponse;

    public function report(ReportAttendanceFilterRequest $request)
    {
        return AttendanceService::getInstance()->report($request);
    }

    public function statistic(StatisticAttendanceFilterRequest $request)
    {
        return AttendanceService::getInstance()->statistic($request);
    }

    public function subject(SubjectAttendanceFilterRequest $request)
    {
        // return AttendanceService::getInstance()->subject($request);
        return $this->successResponse(new SubjectAttendancesResource(AttendanceService::getInstance()->subject($request)));
    }

    /** Dars monitoringi uchun funksiyalar; */
    public function basic(LessonAttendanceFilterRequest $request)
    {
        return AttendanceService::getInstance()->basic($request);
    }

    public function teacher(Request $request)
    {
        return AttendanceService::getInstance()->teacher($request);
    }

    public function group(Request $request)
    {
        return AttendanceService::getInstance()->group($request);
    }

    public function faculty(Request $request)
    {
        return AttendanceService::getInstance()->faculty($request);
    }

    public function pair(Request $request)
    {
        return AttendanceService::getInstance()->pair($request);
    }
}