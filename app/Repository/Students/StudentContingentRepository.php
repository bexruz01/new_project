<?php

namespace App\Repository\Students;

use App\Models\User\Student;
use Closure;

class StudentContingentRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function getData(Closure $closure)
    {
        return $closure(Student::query())
            ->orderBy('updated_at', 'desc')
            ->paginate(request()->get('per_page', 10));
    }
}