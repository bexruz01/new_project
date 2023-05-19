<?php

namespace App\Http\Controllers\Students;

use App\Exports\StudentExport;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\StudentFilterRequest;
use App\Models\Additional\Building;
use App\Services\Students\StudentContingentService;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    use ApiResponse;

    public function index(StudentFilterRequest $request)
    {
        return StudentContingentService::getInstance()->students($request);
    }

    public function export(StudentFilterRequest $request)
    {
        return Excel::download(new StudentsExport($request), 'students.xlsx');
    }
}
