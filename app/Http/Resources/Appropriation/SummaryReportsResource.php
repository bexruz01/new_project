<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class SummaryReportsResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'subjects' => $this->getSubjects(),
            'students' => $this->getStudents(),
        ];
    }

    protected function getSubjects()
    {
        $subjects = [];
        foreach ($this->academic_group_subjects ?? [] as $group_subject)
            $subjects[] = [
                'id' => optional($group_subject->subject)->id,
                'subject' => optional($group_subject->subject)->name,
            ];
        return $subjects;
    }

    protected function getStudents()
    {
        $list = [];
        foreach ($this->students ?? [] as $student)
            $list[] = [
                'student' => $student->full_name,
                'exam_rating' => $this->getRating($student->exam_schedule_results),
            ];
        return $list;
    }

    /** Studentning guruhidagi har bir fan bo'yicha natijasini oladi, natijasi bo'lmas, null qaytaradi. Tartibi fanlar ro'yhati bilan bir hil bo'lgani uchun fanning idisi va nameni jo'natish shart emas! */
    protected function getRating($results)
    {
        $list = [];
        $bool = false;
        foreach ($this->getSubjects() as $subject) {
            $bool = true;
            foreach ($results as $result)
                if ($subject['id'] == optional($result->exam_schedule_subject)->subject_id) {
                    $list[] = [
                        // 'id' => $subject['id'],
                        // 'subject' => $subject['subject'],
                        'rating' => $result->rating,
                        'position' => optional($result->exam_schedule_subject)->final_exam_position,
                    ];
                    $bool = false;
                }
            if ($bool) $list[] = [
                // 'id' => null,
                // 'subject' => null,
                'rating' => null,
                'position' => null,
            ];
        }
        return $list;
    }
}