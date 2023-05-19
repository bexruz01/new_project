<?php

namespace App\Traits;


trait Crud
{
    public function store($request)
    {
        $model = new $this->modelClass;
        $storeReq = $request->duplicate();
        if ($request->has($model->translatable)) {
            foreach ($model->translatable as $item) {
                if (is_array($request->$item)) {
                    $storeReq->offsetUnset($item);
                    $storeReq->offsetSet($item, $request->$item[$request->header('lang') ?? app()->getLocale()]);
                }
            }
        }
        $model = $this->modelClass::create($storeReq->only($model->fillable));
        $model = $this->attachTranslates($model, $request);
        return $this->attachFiles($model, $request);
    }


    public function update($id, $request)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->update($request->only($model->fillable));
        $model = $this->attachTranslates($model, $request);
        return $this->attachFiles($model, $request);
    }

    public function attachFiles($model, $request)
    {
        if ($model->fileFields) {
            foreach ($model->fileFields as $item) {
                if ($request->file($item)) {
                    $fileName = generateRandomString() . '.' . $request->$item->extension();
                    $model->$item = $fileName;
                    fileUpload($request->file($item), $fileName, $model->getTable() . '/' . $item);
                }
            }
            $model->save();
        }
        return $model;
    }

    public function attachTranslates($model, $request)
    {
        if (isset($model->translatable)) {
            if (is_array($model->translatable)) {
                $model->setTranslationsArray($request->only($model->translatable));
            }
        }
        return $model;
    }
}