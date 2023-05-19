<?php

namespace App\Models\Additional;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovSpecialty extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public $translatable = ['name'];
    public $table = 'gov_specialties';

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}