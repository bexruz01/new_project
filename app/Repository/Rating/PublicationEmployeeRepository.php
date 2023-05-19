<?php

namespace App\Repository\Rating;

use App\Models\Additional\Department;
use App\Models\User\Employee;
use App\Models\Rating\PublicationEmployee;
use Closure;

class PublicationEmployeeRepository
{
    public static function getInstance(): PublicationEmployeeRepository
    {
        return new static();
    }

    public function publication_employee(Closure $closure)
    {
        return $closure(PublicationEmployee::query())
            ->get();
    }

    public function department(Closure $closure)
    {
        return $closure(Department::query())
            ->where('type', 'department')
            ->paginate(request()->get('per_page', 10));
    }

    public function employee(Closure $closure)
    {
        return $closure(Employee::query())
            ->paginate(request()->get('per_page', 10));
    }
}