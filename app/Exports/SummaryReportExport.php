<?php

namespace App\Exports;

use App\Services\Appropriation\AppropriationService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryReportExport implements FromView
{
    public $request, $data;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $this->data = AppropriationService::getInstance()->summary_report($this->request);
        $subjects = $this->getSubjects();
        $students = $this->getStudents();
        return view('exports.summary_report', [
            'students' => $students,
            'subjects' => $subjects,
        ]);
    }

    protected function getSubjects()
    {
        $subjects = [];
        foreach ($this->data?->academic_group_subjects as $group_subject)
            $subjects[] = [
                'id' => optional($group_subject->subject)->id,
                'name' => optional($group_subject->subject)->name,
            ];
        return $subjects;
    }

    protected function getRating($results)
    {
        $list = [];
        $bool = false;
        foreach ($this->getSubjects() as $subject) {
            $bool = true;
            foreach ($results as $result)
                if ($subject['id'] == $result->exam_schedule_subject?->subject_id) {
                    $list[] = [
                        'rating' => $result->rating,
                        'position' => $result->exam_schedule_subject?->final_exam_position,
                    ];
                    $bool = false;
                }
            if ($bool)
                $list[] = [
                    'rating' => 0,
                    'position' => 0,
                ];
        }
        return $list;
    }

    protected function getStudents()
    {
        $list = [];
        foreach ($this->data?->students as $student)
            $list[] = [
                'full_name' => $student->full_name,
                'exam_rating' => $this->getRating($student->exam_schedule_results),
            ];
        return $list;
    }
}