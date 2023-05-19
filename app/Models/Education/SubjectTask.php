<?php

namespace App\Models\Education;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTask extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}