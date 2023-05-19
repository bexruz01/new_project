<?php

use App\Http\Controllers\Statistics\StatisticController;

$router->group(['prefix' => 'statistic', 'as' => 'statistic.'], function () use ($router) {

    $router->group(['prefix' => '/student'], function () use ($router) {

        $router->group(['prefix' => '/general'], function () use ($router) {
            $router->get('/', [StatisticController::class, 'general']);
            $router->get('/course', [StatisticController::class, 'student_course']);
            $router->get('/specialty', [StatisticController::class, 'student_specialty']);
            $router->get('/nation', [StatisticController::class, 'student_nation']);
            $router->get('/region', [StatisticController::class, 'student_location']);
        });

        $router->group(['prefix' => '/social'], function () use ($router) {
            $router->get('/social', [StatisticController::class, 'student_social']);
            $router->get('/course', [StatisticController::class, 'student_social_course']);
        });

        $router->get('/category', [StatisticController::class, 'student_category']);
    });

    $router->group(['prefix' => '/teacher', 'as' => 'teacher.'], function () use ($router) {
        $router->get('/academic-degree', [StatisticController::class, 'academic_degree']);
        $router->get('/academic-title', [StatisticController::class, 'academic_title']);
        $router->get('/position', [StatisticController::class, 'position']);
        $router->get('/work-form', [StatisticController::class, 'work_form']);
    });

    $router->get('/resources', [StatisticController::class, 'resources']);
    $router->get('/contract', [StatisticController::class, 'contract']);
    $router->get('/employment', [StatisticController::class, 'employment']);
    $router->get('/appropriation', [StatisticController::class, 'appropriation']);
    $router->get('/training', [StatisticController::class, 'training']);

    //----------------New tasks-------------------
    $router->controller(StatisticController::class)->group(function () use ($router) {
        // $router->get('/admission-faculty', 'admission_faculty');
        // $router->get('/admission-region', 'admission_region');
        $router->get('/employees', 'employees');
    });
});