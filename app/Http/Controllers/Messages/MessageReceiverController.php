<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\MessageReceiverRequest;
use App\Http\Resources\Messages\MessageReceiverResource;
use App\Models\Messages\MessageReceiver;
use App\Services\Messages\Contracts\MessageReceiverServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MessageReceiverController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MessageReceiverServiceInterface $message)
    {
        $mesages=MessageReceiverResource::collection($message->filter($request));
        return $this->success($mesages);
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
    public function store(MessageReceiverRequest $request, MessageReceiverServiceInterface $message)
    {
        $result=MessageReceiverResource::collection($message->store($request));
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
        $message=MessageReceiver::where('message_id',$id)->get();
        $result=MessageReceiverResource::collection($message);
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
