<?php

namespace App\Models\Additional;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reference extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public array $translatable = ['name'];
    protected $table = 'references';
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}