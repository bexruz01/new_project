<?php

namespace App\Repository\SelectData;

use App\Models\Additional\Week;
use Closure;

class StatisticalRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getDataList(Closure $closure)
    {
        return [
            [
                'key' => 'lesson_monitoring',
                'name' => 'Dars monitoringi',
            ],
            [
                'key' => 'group_monitoring',
                'name' => 'Guruh monitoringi',
            ],
            [
                'key' => 'faculty_monitoring',
                'name' => 'Fakultet monitoringi',
            ],
            [
                'key' => 'pair_monitoring',
                'name' => 'Juftlik monitoringi',
            ],
            [
                'key' => 'employee_monitoring',
                'name' => 'Xodim monitoringi',
            ],
        ];
    }

}


