<?php

namespace App\Traits;

use Illuminate\Support\Str;


trait Scopes
{
    public $key;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->key = Str::singular($this->getTable());
    }

    public function scopeWhereEqual($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->where($tableField, $request->$requestField);
    }

    private function getRequest($request = null)
    {
        if ($request)
            return $request;
        return request();
    }

    public function scopeWhereLike($query, $filedName, $request = null)
    {
        $request = $this->getRequest($request);
        if ($request->$filedName)
            $query->where($filedName, 'ilike', '%' . $request->$filedName . '%');
    }

    public function scopeWhereHasLike($query, $relationName, $filedName, $request = null)
    {
        $request = $this->getRequest($request);
        if ($request->$filedName)
            $query->whereHas($relationName, function ($query) use ($filedName, $request) {
                $query->where($filedName, 'ilike', '%' . $request->$filedName . '%');
            });
    }

    public function scopeWhereBetween2($query, $fieldName, $request = null)
    {
        $request = $this->getRequest($request);
        $start = $fieldName . '_start';
        $end = $fieldName . '_end';
        if ($request->$start) {
            $query->whereDate($fieldName, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->whereDate($fieldName, '<=', $request->$end);
        }
    }

    public function scopeWhereBetween3($query, $fieldName, $request = null)
    {
        $request = $this->getRequest($request);
        $start = $fieldName . '_start';
        $end = $fieldName . '_end';
        if ($request->$start) {
            $query->where($fieldName, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->where($fieldName, '<=', $request->$end);
        }
    }

    public function scopeWhereSearch($query, $fieldNames, $request = null)
    {
        $request = $this->getRequest($request);
        $search = $request->get('search', '');
        $query->where(function ($query) use ($fieldNames, $search) {
            foreach ($fieldNames as $field) {
                $query->orWhere($field, 'ilike', '%' . $search . '%');
            }
        });
    }

    public function scopeCustomPaginate($query, $per_page = null, $requestField = 'per_page', $request = null)
    {
        $request = getRequest($request);
        return $query->paginate($request->get($requestField, $per_page ?? self::count()));
    }

    public function scopeSort($query)
    {
        $order = requestOrder();
        $query->orderBy($order['key'], $order['value']);
    }

    public function scopeWhereHasEqual($query, $relationName, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereHas($relationName, function ($query) use ($tableField, $requestField, $request) {
                $query->where($tableField, $request->$requestField);
            });
    }
}
