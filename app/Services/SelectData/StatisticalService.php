<?php

namespace App\Services\SelectData;

use App\Repository\SelectData\StatisticalRepository;
use App\Traits\ApiResponse;

class StatisticalService
{
    use ApiResponse;

    public $repository;

    public function __construct(StatisticalRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): StatisticalService
    {
        return new static(StatisticalRepository::getInstance());
    }


    public function getStatisticalList($request)
    {

        return $this->successResponse([
            [
                "key" => "teacher",
                "name" => "O'qituvchi bo'yicha",
            ],
            [
                "key" => "group",
                "name" => "Guruh bo'yicha",
            ],
            [
                "key" => "faculty",
                "name" => "Fakultet bo'yicha",
            ],
            [
                "key" => "pair",
                "name" => "Juftlik bo'yicha",
            ],
        ]);
    }
}