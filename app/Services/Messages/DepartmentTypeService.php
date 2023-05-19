<?php

namespace App\Services\Messages;

use App\Services\Messages\Contracts\DepartmentTypeServiceInterface;
use App\Models\Messages\DepartmentType;
use Illuminate\Http\Request;

class DepartmentTypeService implements DepartmentTypeServiceInterface
{
    protected $department_type;

    public function __construct()
    {
        $this->department_type = DepartmentType::class;
    }

    public function filter(Request $request)
    {
        return $this->department_type::all();
    }

    public function store(Request $request)
    {
        $department_type = $this->department_type::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return $department_type;
    }
    public function delete($id)
    {
        return $this->department_type::destroy($id);
    }
}