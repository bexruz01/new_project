<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Models\Translation;

class MessageStatus extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;
    public array $translatable = ['name'];
    protected $table = "message_status";
    protected $fillable = ['key'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function statusID($key = 'draft')
    {
        if ($key == 'null')
            $key = 'draft';
        return self::where('key', $key)->first()->id;
    }

    public function getNameAttribute($value)
    {
        return $this->translateName->field_value ?? ($value ?? '');
    }

    public function translateName()
    {
        return $this->hasOne(Translation::class, 'field_id', 'id')
            ->where('table_name', $this->getTable())
            ->where('field_name', 'name')
            ->where('language_url', app()->getLocale());
    }
}