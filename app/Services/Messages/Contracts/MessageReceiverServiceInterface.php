<?php

namespace App\Services\Messages\Contracts;

use Illuminate\Http\Request;

interface MessageReceiverServiceInterface
{
    public function filter(Request $request);
    public function search(Request $request);
    public function store(Request $request);
    public function update(Request $request, $id);
    public function delete($id);
}
