<?php

use App\Http\Resources\ListResource;
use App\Models\Academic\AcademicYear;
use App\Models\Additional\Language;
use Illuminate\Database\Eloquent\Collection;

function mergeUserIdToRequest($request)
{
    if (!$request->user_id)
        $request->merge(['user_id' => auth()->id()]);
    return $request;
}


function paginatedResponse($collection, $result): array
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


function getPagination($collection): array
{
    return [
        'total' => $collection->total(),
        'count' => $collection->count(),
        'per_page' => intval($collection->perPage()),
        'current_page' => $collection->currentPage(),
        'total_pages' => $collection->lastPage()
    ];
}

function withPagination($collection, $resourceClass = ListResource::class, $resultKey = 'data', $paginationKey = 'pagination'): array
{
    return [$resultKey => $resourceClass::collection($collection), $paginationKey => getPagination($collection)];
}

// function defaultLocale()
// {
//     return Language::where('default', true)->first();
// }

// function allLanguage(): Collection
// {
//     return Language::all();
// }

// function defaultLocaleCode()
// {
//     return optional(defaultLocale())->url;
// }

function getRequest($request = null)
{
    return $request ?? request();
}

function currentAcademicYear()
{
    return AcademicYear::where('is_current', true)->first();
}