<?php

namespace App\Models\Additional;

use App\Traits\Scopes;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory, HasTranslations, Scopes;

    protected $guarded = [];

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}