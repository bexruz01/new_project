<?php

namespace App\Http\Controllers\SelectData;

use App\Services\SelectData\AcademicTrainingService;
use App\Services\SelectData\AcademicGroupService;
use App\Services\SelectData\AcademicYearService;
use App\Services\SelectData\DepartmentService;
use App\Services\SelectData\SpecialtyService;
use App\Services\SelectData\ReferenceService;
use App\Services\SelectData\BuildingService;
use App\Services\SelectData\SemesterService;
use App\Services\SelectData\EduPlanService;
use App\Services\SelectData\StatisticalService;
use App\Services\SelectData\SubjectService;
use App\Services\SelectData\WeekService;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class FilterDataController
{
    use ApiResponse;


    /**
     *  Ta'lim turlari ro'yhatini qaytaruvchi funksiya;
     */
    public function getEduTypeList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('edu-types', $request);
    }


    /**
     *  Ta'lim shakllari ro'yhatini qaytaruvchi funksiya;
     */
    public function getEduFormList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('edu-forms', $request);
    }


    /**
     *  Yashash joylari ro'yhatini qaytaruvchi funksiya;
     */
    public function getLivePlaceList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('live-places', $request);
    }


    /**
     *  To'lov shakllari ro'yhatini qaytaruvchi funksiya;
     */
    public function getPaymeTypeList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('specialty-type', $request);
    }


    /**
     *  To'lov turlari ro'yhatini qaytaruvchi funksiya;
     */
    public function getPaymentFormList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('payment-types', $request);
    }


    /**
     *  Ijtimoiy toifalar ro'yhatini qaytaruvchi funksiya;
     */
    public function getSocialCategoryList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('social-categories', $request);
    }

    /**
     *  Ta'lim tillari ro'yhatini qaytaruvchi funksiya;
     */
    public function getEduLangList(Request $request)
    {
        return ReferenceService::getInstance()->getReferenceDataList('languages', $request);
    }


    /**
     *  Statistikalar ro'yhatini qaytaruvchi funksiya;
     */
    public function getStatisticList(Request $request)
    {
        return StatisticalService::getInstance()->getStatisticalList($request);
    }


    /**
     *  Mutaxasisliklar ro'yhatini qaytaruvchi funksiya;
     */
    public function getSpecialtyList(Request $request)
    {
        return SpecialtyService::getInstance()->getSpecialtyList($request);
    }

    /**
     *  Fakultetlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getFacultyList(Request $request)
    {
        return DepartmentService::getInstance()->getDepartmentDataList('faculty', $request);
    }


    /**
     *  Kafedralar ro'yhatini qaytaruvchi funksiya;
     */
    public function getDepartmentList(Request $request)
    {
        return DepartmentService::getInstance()->getDepartmentDataList('department', $request);
    }

    /**
     *  Semestrlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getSemestrList(Request $request)
    {
        return SemesterService::getInstance()->getSemesterList($request);
    }

   

    /**
     *  Semestrlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getSemestrNumberList(Request $request)
    {
        return $this->successResponse([
            ['id' => 1, 'semester' => '1'],
            ['id' => 2, 'semester' => '2'],
            ['id' => 3, 'semester' => '3'],
            ['id' => 4, 'semester' => '4'],
            ['id' => 5, 'semester' => '5'],
            ['id' => 6, 'semester' => '6'],
            ['id' => 7, 'semester' => '7'],
            ['id' => 8, 'semester' => '8'],
        ]);
    }

    /**
     *  Semester turlari ro'yhatini qaytaruvchi funksiya;
     */
    public function getSemesterTypeList()
    {
        return SemesterService::getInstance()->getSemesterTypeList();
    }

    /**
     *  O'quv yillari ro'yhatini qaytaruvchi funksiya;
     */
    public function getAcademicYearList(Request $request)
    {
        return AcademicYearService::getInstance()->getAcademicYearList($request);
    }

    /**
     *  Guruhlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getAcademicGroupList(Request $request)
    {
        return AcademicGroupService::getInstance()->getAcademicGroupList($request);
    }

    /**
     *  O'quv rejalari ro'yhatini qaytaruvchi funksiya;
     */
    public function getEduPlanList(Request $request)
    {
        return EduPlanService::getInstance()->getEduPlanList($request);
    }

    /**
     *  Fanlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getSubjectList(Request $request)
    {
        return SubjectService::getInstance()->getSubjectList($request);
    }


    /**
     *  Mashg'ulotlar ro'yhatini qaytaruvchi funksiya;
     */
    public function getAcademicTrainingList(Request $request)
    {
        return AcademicTrainingService::getInstance()->getAcademicTrainingList($request);
    }


    /**
     *  Binolar ro'yhatini qaytaruvchi funksiya;
     */
    public function getBuildingList(Request $request)
    {
        return BuildingService::getInstance()->getBuildingList($request);
    }


    /**
     *  Kurslar ro'yhatini qaytaruvchi funksiya;
     */
    public function getCourseList()
    {
        return $this->successResponse(
            [
                ['id' => 1, 'name' => 1],
                ['id' => 2, 'name' => 2],
                ['id' => 3, 'name' => 3],
                ['id' => 4, 'name' => 4],
                ['id' => 5, 'name' => 5],
            ]
        );
    }


    /**
     *  Haftalar ro'yhatini qaytaruvchi functiya;
     */
    public function getWeekList(Request $request)
    {
        return WeekService::getInstance()->getWeekList($request);
    }
}