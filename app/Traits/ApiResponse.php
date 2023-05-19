<?php

namespace App\Traits;

trait ApiResponse
{

    protected function successResponse($data, int $code = 200)
    {
        return response()->json(['result' => $data, 'errors' => null], $code);
    }


    protected function errorResponse($data = null, int $code = 422)
    {
        return response()->json(['result' => null, 'errors' => $data], $code);
    }



    public function successPaginate($collection)
    {
        $pagination = [
            'total' => $collection->total(),
            'count' => $collection->count(),
            'per_page' => intval($collection->perPage()),
            'current_page' => $collection->currentPage(),
            'last_page' => $collection->lastPage()
        ];
        return ['result' => $collection, 'pagination' => $pagination];
    }


    /////////////////////////////////////Xabarlar uchun response/////////////////////////////////////
    public function success($result, $code = 200)
    {
        return response()->json(['data' => $result], $code);
    }

    public function error($result, $code = 400)
    {
        return response()->json(['error' => $result], $code);
    }
    /////////////////////////////////////Xabarlar uchun response/////////////////////////////////////

}