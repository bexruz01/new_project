<?php

namespace App\Http\Controllers\Rating;

use App\Services\Rating\PublicationEmployeeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class PublicationEmployeesController extends Controller
{
    use ApiResponse;

    public function teachers(Request $request)
    {
        return PublicationEmployeeService::getInstance()->teachers($request);
    }

    public function teacher($id)
    {
        return PublicationEmployeeService::getInstance()->teacher($id);
    }


    public function department(Request $request)
    {
        return PublicationEmployeeService::getInstance()->department($request);
    }

    public function faculty(Request $request)
    {
        return PublicationEmployeeService::getInstance()->faculty($request);
    }
}
