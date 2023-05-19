<?php

namespace App\Http\Controllers\Appropriation;

use App\Services\Appropriation\AppropriationService;
use App\Exports\SummaryReportAttendanceExport;
use App\Exports\AcademicDebtAttendanceExport;
use App\Exports\SummaryReportExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AppropriationController extends Controller
{
    use ApiResponse;

    public function rating_reports(Request $request)
    {
        return AppropriationService::getInstance()->rating_reports($request);
    }

    public function rating_report($id)
    {
        return AppropriationService::getInstance()->rating_report($id);
    }

    public function summary_report(Request $request)
    {
        return AppropriationService::getInstance()->summary_report($request);
    }

    public function academic_debt(Request $request)
    {
        return AppropriationService::getInstance()->academic_debt($request);
    }

    /** Excel export */
    public function academic_debt_export(Request $request)
    {
        return Excel::download(new AcademicDebtAttendanceExport($request), 'academic_debt.xlsx');
    }

    public function summary_report_export(Request $request)
    {
        return Excel::download(new SummaryReportAttendanceExport($request), 'summary_report.xlsx');;
    }

    public function summary_report_export_view(Request $request)
    {
        return Excel::download(new SummaryReportExport($request), 'summary_report.xlsx');;
    }
}