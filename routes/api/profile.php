<?php

use App\Http\Controllers\UserProfile\UserProfileController;

$router->group(['prefix' => '/profile', 'as' => 'profile.'], function () use ($router) {
    $router->get('/', [UserProfileController::class, 'show'])
        ->name('show');
    $router->post('/', [UserProfileController::class, 'update'])
        ->name('update');
});