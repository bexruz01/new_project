<?php

namespace App\Traits;

trait ApiPaginate
{
    function paginate($collection, $result)
    {
        $pagination = [
            'total' => $collection->total(),
            'count' => $collection->count(),
            'per_page' => intval($collection->perPage()),
            'current_page' => $collection->currentPage(),
            'total_pages' => $collection->lastPage()
        ];
        return ['result' => $result, 'pagination' => $pagination];
    }
}
