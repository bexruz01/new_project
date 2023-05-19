<?php

namespace App\Http\Controllers\Messages;

use App\Services\Messages\Contracts\DepartmentTypeServiceInterface;
use App\Http\Resources\Messages\DepartmentTypeResource;
use App\Http\Requests\Messages\DepartmentTypeRequest;
use App\Models\Messages\DepartmentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class DepartmentTypeController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DepartmentTypeServiceInterface $departmentTypeService)
    {
        $results = DepartmentTypeResource::collection($departmentTypeService->filter($request));
        return $this->success($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentTypeRequest $request, DepartmentTypeServiceInterface $departmentTypeService)
    {
        $result = new DepartmentTypeResource($departmentTypeService->store($request));
        return $this->success($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = new DepartmentTypeResource(DepartmentType::findOrFail($id));
        return $this->success($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}