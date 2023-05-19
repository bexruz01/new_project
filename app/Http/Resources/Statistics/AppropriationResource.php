<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class AppropriationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name ?? '',
            'student_count' => $this->students->count(),
            'count_rating' => $this->countRating(),
            'count_rating_5' => $this->countCurrentRating(5),
            'percent_5' => $this->retingProsent(5),
            'count_rating_4' => $this->countCurrentRating(4),
            'percent_4' => $this->retingProsent(4),
            'count_rating_3' => $this->countCurrentRating(3),
            'percent_3' => $this->retingProsent(3),
            'count_rating_2' => $this->countCurrentRating(2),
            'percent_2' => $this->retingProsent(2),
        ];
    }

    public function countRating()
    {
        $count = 0;
        foreach ($this->students as $student)
            $count += $student->exam_schedule_results_count;
        return $count;
    }

    public function countCurrentRating($number)
    {
        $count = 0;
        foreach ($this->students as $student)
            foreach ($student->exam_schedule_results as $exam)
                if ($exam->rating == $number)
                    $count += 1;
        return $count;
    }

    public function retingProsent($number)
    {
        if ($this->students->count() == 0)
            return 0;

        return round(($this->countCurrentRating($number) / $this->students->count()) * 100, 2);
    }
}