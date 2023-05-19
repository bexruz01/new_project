<?php

use App\Http\Controllers\Appropriation\AppropriationController;

$router->group(['prefix' => '/appropriation', 'as' => 'appropriation.'], function () use ($router) {
    $router->get('/rating-report', [AppropriationController::class, 'rating_reports'])
        ->name('rating-reports');
    $router->get('/rating-report/{id}', [AppropriationController::class, 'rating_report'])
        ->name('rating-report');
    $router->get('/summary-report', [AppropriationController::class, 'summary_report'])
        ->name('summary-report');
    $router->get('/academic-debt', [AppropriationController::class, 'academic_debt'])
        ->name('academic-debt');

    /** Excel export routes; */
    // $router->get('/academic-debt-export', [AppropriationController::class, 'academic_debt_export']);
    // $router->get('/summary-report-export', [AppropriationController::class, 'summary_report_export'])->name('summary-export');
});