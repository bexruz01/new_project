<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\AcademicYear;
use App\Traits\HasTranslations;

class Publication extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'publications';

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function rating_critery()
    {
        return $this->hasOne(RatingCritery::class, 'id', 'rating_criteria_id');
    }

    public function academic_year()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id');
    }
}