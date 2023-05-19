<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected $table = 'translates';
    protected $fillable = ['table_name', 'field_name', 'field_id', 'field_value', 'language_url', 'translatable_id', 'translatable_type'];


    public static function updateOrCreate($table_name, $field_name, $field_id, $field_value, $language_url)
    {
        $t = Translation::query()->where('table_name', $table_name)
            ->where('field_id', $field_id)
            ->where('field_value', $field_value)
            ->where('language_url', $language_url)->exists();
        if ($t) {
            Translation::query()->where('table_name', $table_name)
                ->where('field_id', $field_id)
                ->where('field_value', $field_value)
                ->where('language_url', $language_url)->update(['field_value' => $field_value]);
        } else {
            Translation::create([
                'table_name' => $table_name,
                'field_name' => $field_name,
                'field_id' => $field_id,
                'field_value' => $field_value,
                'language_url' => $language_url
            ]);
        }
    }

    public function translatable()
    {
        return $this->morphTo();
    }
}