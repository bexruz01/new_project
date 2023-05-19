<?php

namespace App\Http\Resources\Statistics;

use App\Models\Additional\Reference;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSocialStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faculty' => $this->name,
            'list' => $this->studentCountInCategory(),
        ];
    }

    public function getCategoryList()
    {
        return Reference::where('table_name', 'social-categories')
            // ->where('status', true)
            ->select('id', 'name')
            ->get();
    }

    public function studentCountInCategory()
    {
        $list = [];
        foreach ($this->getCategoryList() as $category) {
            $count = 0;
            foreach ($this->students as $student)
                if ($category->id == $student->social_category_id) {
                    $count = $student->count;
                    break;
                }
            $list[] = [
                'id' => $category->id,
                'name' => $category->name,
                'student_count' => $count,
            ];
        }
        return $list;
    }
}