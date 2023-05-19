<?php

namespace App\Models\Academic;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDegree extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }
}
