<?php

namespace App\Services\Messages\Contracts;

use Illuminate\Http\Request;

interface MessageServiceInterface
{
    public function filter(Request $request);
    public function store(Request $request);
    public function update(Request $request, $id);
    public function show($id);
    public function delete($id);
    public function delete_list(Request $request);
    public function restore($id);
}
