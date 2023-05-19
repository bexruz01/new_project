<?php

    use App\Http\Controllers\Rating\PublicationEmployeesController;

    $router->group(['prefix'=>'rating/', 'as'=>'rating.'], function () use ($router) {

        $router->get('teachers', [PublicationEmployeesController::class, 'teachers']);

        $router->get('teachers/{id}', [PublicationEmployeesController::class, 'teacher']);

        $router->get('department', [PublicationEmployeesController::class, 'department']);

        $router->get('faculty', [PublicationEmployeesController::class, 'faculty']);

    });
