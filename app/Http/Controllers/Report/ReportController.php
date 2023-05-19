<?php

namespace App\Http\Controllers\Report;

use App\Exports\ActiveStudentReportExport;
use App\Exports\ActiveTeacherReportExport;
use App\Services\Report\ReportService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use ApiResponse;

    public function active_teachers(Request $request)
    {
        return ReportService::getInstance()->active_teachers($request);
    }

    public function active_students(Request $request)
    {
        return ReportService::getInstance()->active_students($request);
    }

    public function resources(Request $request)
    {
        return ReportService::getInstance()->resources($request);
    }

    public function audiences(Request $request)
    {
        return ReportService::getInstance()->audiences($request);
    }

    public function audiences_topic(Request $request)
    {
        return ReportService::getInstance()->audiences_topic($request);
    }

    public function teachers(Request $request)
    {
        return ReportService::getInstance()->teachers($request);
    }

    public function teachers_topic(Request $request)
    {
        return ReportService::getInstance()->teachers_topic($request);
    }

    public function exams(Request $request)
    {
        return ReportService::getInstance()->exams($request);
    }

    /** ********* ********* Exel Export *********** ************** *********** */
    public function teacher_export(Request $request)
    {
        return Excel::download(new ActiveTeacherReportExport($request), 'active_teachers.xlsx');
    }

    public function student_export(Request $request)
    {
        return Excel::download(new ActiveStudentReportExport($request), 'active_students.xlsx');
    }
}
