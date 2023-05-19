<?php

namespace App\Services\Messages\Contracts;

use Illuminate\Http\Request;

interface DepartmentTypeServiceInterface
{
    public function filter(Request $request);
    public function store(Request $request);
    public function delete($id);
}
