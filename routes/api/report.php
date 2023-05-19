<?php

use App\Http\Controllers\Report\ReportController;

$router->group(['prefix' => '/report', 'as' => 'report.'], function () use ($router) {
    $router->get('/active-teachers', [ReportController::class, 'active_teachers'])
        ->name('active-teachers');

    $router->get('/active-students', [ReportController::class, 'active_students'])
        ->name('active-students');

    $router->get('/resources', [ReportController::class, 'resources'])
        ->name('resources');

    $router->get('/audiences', [ReportController::class, 'audiences'])
        ->name('audiences');

    $router->get('/audiences/topic', [ReportController::class, 'audiences_topic'])
        ->name('audiences-topic');

    $router->get('/teachers', [ReportController::class, 'teachers'])
        ->name('teachers');

    $router->get('/teachers/topic', [ReportController::class, 'teachers_topic'])
        ->name('teachers-topic');

    $router->get('/exams', [ReportController::class, 'exams'])
        ->name('exams');

    /** Excel export route; */
    // $router->get('/teacher-export', [ReportController::class, 'teacher_export'])
    //     ->name('teacher-export');
    // $router->get('/student-export', [ReportController::class, 'student_export'])
    //     ->name('student-export');
});