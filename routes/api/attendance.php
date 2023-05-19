<?php

use App\Http\Controllers\Attendance\AttendanceController;

$router->group(['prefix' => '/attendances', 'as' => 'attendances.'], function () use ($router) {
    $router->get('/report', [AttendanceController::class, 'report'])
        ->name('report');

    $router->get('/statistic', [AttendanceController::class, 'statistic'])
        ->name('statistic');

    $router->get('/subject', [AttendanceController::class, 'subject'])
        ->name('subject');

    $router->get('/basic', [AttendanceController::class, 'basic'])
        ->name('basic');

    $router->get('/group', [AttendanceController::class, 'group'])
        ->name('group');

    $router->get('/faculty', [AttendanceController::class, 'faculty'])
        ->name('faculty');

    $router->get('/pair', [AttendanceController::class, 'pair'])
        ->name('pair');

    $router->get('/teacher', [AttendanceController::class, 'teacher'])
        ->name('teacher');
});