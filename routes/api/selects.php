<?php

use App\Http\Controllers\SelectData\FilterDataController;

$router->group(['prefix' => 'search/', 'as' => 'search.'], function () use ($router) {

    /** Fakultetlar ro'yhati */
    $router->get('faculty-list', [FilterDataController::class, 'getFacultyList'])
        ->name('faculty-list');

    /** To'lov shakllari ro'yhati */
    $router->get('payment-form-list', [FilterDataController::class, 'getPaymentFormList'])
        ->name('payment-form-list');

    /** Yashash joylari ro'yhati */
    $router->get('live-place-list', [FilterDataController::class, 'getLivePlaceList'])
        ->name('live-place-list');

    /** Semesterlar ro'yhati */
    $router->get('semestr-list', [FilterDataController::class, 'getSemestrList'])
        ->name('semestr-list');

    /** Semester raqamlari ro'yhati */
    $router->get('semestr-number-list', [FilterDataController::class, 'getSemestrNumberList'])
        ->name('semestr-number-list');

    /** Semestr turlari ro'yhati */
    $router->get('semester-type-list', [FilterDataController::class, 'getSemesterTypeList'])
        ->name('semester-type-list');

    /** O'quv yillari ro'yhati */
    $router->get('academic-year-list', [FilterDataController::class, 'getAcademicYearList'])
        ->name('academic-year-list');

    /** Ta'lim turlari ro'yhati */
    $router->get('edu-type-list', [FilterDataController::class, 'getEduTypeList'])
        ->name('edu-type-list');

    /** Ta'lim shakllari ro'yhati */
    $router->get('edu-form-list', [FilterDataController::class, 'getEduFormList'])
        ->name('edu-form-list');

    /** Guruhlar ro'yhati */
    $router->get('group-list', [FilterDataController::class, 'getAcademicGroupList'])
        ->name('group-list');

    /** O'quv rejalari ro'yhati */
    $router->get('edu-plan-list', [FilterDataController::class, 'getEduPlanList'])
        ->name('edu-plan-list');

    /** Statistikalari ro'yhati */
    $router->get('statistic-list', [FilterDataController::class, 'getStatisticList'])
        ->name('statistic-list');

    /** Kafedralar ro'yhati */
    $router->get('department-list', [FilterDataController::class, 'getDepartmentList'])
        ->name('department-list');

    /** Ijtimoiy toifalar ro'yhati */
    $router->get('social-category-list', [FilterDataController::class, 'getSocialCategoryList'])
        ->name('social-category-list');

    /** Fanlar ro'yhati */
    $router->get('subject-list', [FilterDataController::class, 'getSubjectList'])
        ->name('subject-list');

    /** Mashg'ulotlar ro'yhati */
    $router->get('academic-training-list', [FilterDataController::class, 'getAcademicTrainingList'])
        ->name('academic-training-list');

    /** Ta'lim tillari ro'yhati */
    $router->get('edu-lang-list', [FilterDataController::class, 'getEduLangList'])
        ->name('edu-lang-list');

    /** Mutaxasisliklar ro'yhati */
    $router->get('specialty-list', [FilterDataController::class, 'getSpecialtyList'])
        ->name('specialty-list');

    /** Kurslar ro'yhati */
    $router->get('course-list', [FilterDataController::class, 'getCourseList'])
        ->name('course-list');

    /** Mutaxasisliklar ro'yhati */
    $router->get('building-list', [FilterDataController::class, 'getBuildingList'])
        ->name('building-list');

    /** Haftalar ro'yhati; */
    $router->get('week-list', [FilterDataController::class, 'getWeekList'])
        ->name('week-list');
});