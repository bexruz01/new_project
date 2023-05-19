<?php

namespace App\Models\Rating;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationType extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'publication_types';

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}