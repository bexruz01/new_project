<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/************************************************************** */
/** Hozircha authorizatsiyadan chiqarib turilibdi !!! */

use App\Http\Controllers\Appropriation\AppropriationController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Report\ReportController;



/************************************************************** */

Route::group(['middleware' => ['auth:sanctum', 'deriction']], function () use ($router) {
    
    Route::get('appropriation/academic_debt_export', [AppropriationController::class, 'academic_debt_export']);
    Route::get('/students/export', [StudentsController::class, 'export']);
    Route::get('/report/teacher-export', [ReportController::class, 'teacher_export']);
    Route::get('/report/student-export', [ReportController::class, 'student_export']);
    // Route::controller(AppropriationController::class)->group(function () {
    //     Route::get('/academic-debt-export', 'academic_debt_export');

    //     Route::get('/summary_report_export', 'summary_report_export');

    //     Route::get('/summary_report_export_view', 'summary_report_export_view');
    // });
    /** User Profile routelari; */
    @include('api/profile.php');

    /** Talabalar bo'limi routelari; */
    @include('api/students.php');

    /** O'quv jarayoni bo'limi routelari; */
    @include('api/edu_process.php');

    /** Davomat bo'limi routelari; */
    @include('api/attendance.php');

    /** O'zlashtirish bo'limi routelari; */
    @include('api/appropriation.php');

    /** Reyting bo'limi routelari; */
    @include('api/rating.php');

    /** Statistika bo'limi routelari; */
    @include('api/statistic.php');

    /** Hisobotlar bo'limi routelari; */
    @include('api/report.php');

    /** Habarlar bo'limi routelari; */


    /** Select maydonlar routelari; */
    @include('api/selects.php');
});

@include('api/messages.php');

// $router->group(['prefix' => '/export'], function () use ($router) {
//     $router->get('/student', function () {
//         return "Export link: https://api-rahbar.eduni.uz/api/students/export";
//     });
//     $router->get('/active-student', function () {
//         return "Export link: https://api-rahbar.eduni.uz/api/report/student-export";
//     });
//     $router->get('/active-teacher', function () {
//         return "Export link: https://api-rahbar.eduni.uz/api/report/teacher-export";
//     });
//     $router->get('/academic-debt', function () {
//         return "Export link: https://api-rahbar.eduni.uz/api/appropriation/academic-debt-export";
//     });
//     $router->get('/summary', function () {
//         return "Export link: https://api-rahbar.eduni.uz/api/appropriation/summary_report_export_view";
//     });
// });
