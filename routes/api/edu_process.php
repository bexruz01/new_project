<?php

use App\Http\Controllers\EduProcess\EduProcessController;

$router->group(['prefix' => '/edu-process', 'as' => 'edu-process.'], function () use ($router) {

    /** O'quv rejalar ro'yhati; */
    $router->get('/edu-plans', [EduProcessController::class, 'edu_plans'])
        ->name('edu-plans');
    $router->get('/edu-plans/{id}', [EduProcessController::class, 'edu_plan'])
        ->name('edu-plan');
    $router->get('/curriculum/{id}', [EduProcessController::class, 'curriculum'])
        ->name('curriculum');

    /** Dars jadvalini ko'rish; */
    $router->get('/lesson-schedules', [EduProcessController::class, 'lesson_schedules'])
        ->name('lesson-schedules');
    $router->get('/lesson-schedules/{id}', [EduProcessController::class, 'lesson_schedule'])
        ->name('lesson-schedule');

    /** Nazorat jadvalini ko'rish; */
    $router->get('/exam-schedules', [EduProcessController::class, 'exam_schedules'])
        ->name('exam-schedules');
    $router->get('/exam-schedules/{id}', [EduProcessController::class, 'exam_schedule'])
        ->name('exam-schedule');
});