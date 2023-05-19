<?php

namespace App\Traits;

use App\Models\Additional\Translate;
use Exception;
use Illuminate\Support\Facades\DB;

trait HasTranslations
{
    protected $locale;
    protected $setDefaultTranslation;

    public function setLocale($key)
    {
        $this->locale = $key;
    }

    public function getLocale()
    {
        return $this->locale ?: app()->getLocale();
    }

    // Relation
    public function translations()
    {
        //    return $this->morphMany(Translate::class, 'translatable');
        return DB::table('translates')->where('table_name', $this->getTable())->where('field_id', $this->id);
    }

    public function getTranslationsAttribute()
    {
        return $this->translations()->get();
    }

    // barcha fieldlarni bitta tildagi tarjimalari
    public function getTranslationAttributes($locale = null)
    {
        return $this->translations->where('language_url', $locale ?: $this->getLocale());
    }

    // bitta tilni bitta tildagi tarjimasi
    public function translate($field, $locale = null)
    {
        $field = 'name';
        if ($this->isAvailableField($field))
            return optional($this->getTranslationAttributes($locale)->firstWhere('field_name', $field))->field_value;
        throw new Exception("This field is not in translatables array: $field");
    }

    // bitta fieldni barcha tillardagi tarjimasi
    public function translates($field)
    {
        if ($this->isAvailableField($field))
            return $this->translations->where('field_name', $field);
        throw new Exception("This field is not in translatables array: $field");
    }

    //
    function pluckTranslates($field)
    {
        return $this->translates($field)->all() ? $this->translates($field)->pluck('field_value', 'language_url') : null;
    }

    // field bor yoki yo'qligini tekshirish
    protected function isAvailableField($field)
    {
        return in_array($field, $this->translatable);
    }

    // // bitta fieldni bitta til bo'yicha tarjimasini save qilish
    // public function setTranslation($field, $value, $locale = null)
    // {
    //     $this->translations()->updateOrInsert(
    //         [
    //             'field_name' => $field,
    //             'language_url' => $locale ?: $this->getLocale()
    //         ],
    //         [
    //             'field_value' => $value,
    //             'table_name' => $this->getTable(),
    //             'field_id' => $this->id
    //         ]
    //     );
    //     if ($locale == defaultLocaleCode()) {
    //         $this->update([$field => $value]);
    //     }
    //     return $this;
    // }

    public function setTranslation($field, $value, $locale = null)
    {
        $this->translations()->updateOrInsert(
            [
                'field_name' => $field,
                'language_url' => $locale ?: $this->getLocale()
            ],
            [
                'field_value' => $value,
                'table_name' => $this->getTable(),
                'field_id' => $this->id,
                'translatable_id' => $this->id,
                'translatable_type' => $this->getMorphClass()
            ]
        );
        if ($locale == defaultLocaleCode()) {
            $this->update([$field => $value]);
        }
        return $this;
    }


    // bitta field tarjimalarni save qilish
    public function setTranslations($field, $array)
    {
        if ($this->isAvailableField($field)) {
            foreach ($array as $locale => $value) {
                $this->setTranslation($field, $value, $locale);
            }
        }
        return $this;
    }

    // bir nechta field tarjimalarini bittada save qilish
    public function setTranslationsArray($array)
    {
        foreach ($array as $field => $value) {
            $this->setTranslations($field, $value);
        }
        return $this;
    }

    //     // Relation
    public function getTranslations()
    {
        return $this->hasMany(Translate::class, 'field_id', 'id')
            ->where('table_name', $this->getTable())
            ->where('language_url', $this->getLocale());
    }

    public function getTranslate($field)
    {
        return $this->getTranslations->firstWhere('field_name', $field)->field_value ?? $this->{$field};
    }
}