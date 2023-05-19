<?php

namespace App\Models\Academic;

use App\Models\Education\EduPlan;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function edu_plans()
    {
        return $this->hasMany(EduPlan::class, 'academic_year_id', 'id');
    }
}