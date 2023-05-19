<?php

namespace App\Models\Rating;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critery extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'criteries';

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}