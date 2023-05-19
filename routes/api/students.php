<?php

use App\Http\Controllers\Students\StudentsController;

$router->group(['prefix' => '/students', 'as' => 'students.'], function () use ($router) {
    $router->get('/contingent', [StudentsController::class, 'index'])
        ->name('contingent');

    /** Exel export api */
    // $router->get('/export', [StudentsController::class, 'export'])
    //     ->name('export');
});