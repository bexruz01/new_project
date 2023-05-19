<?php

use App\Http\Controllers\Messages\DepartmentTypeController;
use App\Http\Controllers\Messages\MessageStatusController;
use App\Http\Controllers\Messages\DepartmentController;
use App\Http\Controllers\Messages\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', [MessageController::class, 'index']);
        Route::get('received', [MessageController::class, 'receivedMessagesList']);
        Route::get('sent', [MessageController::class, 'sentMessagesList']);
        Route::get('draft', [MessageController::class, 'draftMessagesList']);
        Route::post('draft', [MessageController::class, 'saveDraftMessage']);
        Route::put('draft/{message}', [MessageController::class, 'updateDraftMessage']);
        Route::get('draft/{message}', [MessageController::class, 'fetchDraftMessageByID']);
        Route::get('deleted', [MessageController::class, 'deletedMessagesList']);
        Route::post('/', [MessageController::class, 'store']);
        Route::delete('/', [MessageController::class, 'deleteMany']);
        Route::get('status', [MessageStatusController::class, 'index']);
        Route::get('status/{id}', [MessageStatusController::class, 'show']);
        Route::get('{id}', [MessageController::class, 'show']);
        Route::put('/restore', [MessageController::class, 'restoreMany']);
        Route::put('{message}', [MessageController::class, 'updateMessage']);
    });

    Route::prefix('message-receivers')->group(function () {
        Route::get('employees', [MessageController::class, 'fetchEmployeesList']);
        Route::get('students', [MessageController::class, 'fetchStudentsList']);
        Route::put('{messageReceiver}/is_seen', [MessageController::class, 'markMessageAsRead']);
    });

    Route::group(['prefix' => 'department/'], function () {
        Route::get('', [DepartmentController::class, 'index']);
        Route::get('type/', [DepartmentTypeController::class, 'index']);
        Route::get('type/{id}', [DepartmentTypeController::class, 'show']);
        Route::get('{id}', [DepartmentController::class, 'show']);
    });
});