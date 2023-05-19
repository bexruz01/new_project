<?php

namespace App\Services\Messages;

use App\Services\Messages\Contracts\DepartmentServiceInterface;
use App\Models\Messages\Department;
use Illuminate\Http\Request;

class DepartmentService implements DepartmentServiceInterface
{
    protected $department;

    public function __construct()
    {
        $this->department = Department::class;
    }

    public function filter(Request $request)
    {
        $result = $this->department::whereEqual('department_type_id');
        if ($request->get('type', false)) {
            if ($request->get('type') == "department_section")
                $result = $result->whereIn('type', ['department', 'section']);
            else
                $result = $result->whereEqual('type');
        }
        $result = $result->whereEqual('department_id')
            ->whereEqual('status')
            ->sort()->customPaginate();
        return $result;
    }

    public function store(Request $request)
    {
        $department = $this->department::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'status' => $request->status,
            'department_type_id' => $request->department_type_id,
            'department_id' => $request->department_id,

        ]);

        return $department;
    }

    public function delete($id)
    {
        return $this->department::destroy($id);
    }
}