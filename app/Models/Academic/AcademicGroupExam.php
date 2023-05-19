<?php

namespace App\Models\Academic;

use App\Traits\Scopes;
use App\Models\Exam\Exam;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicGroupExam extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'id', 'exam_id');
    }

    public function academic_group()
    {
        return $this->hasOne(AcademicGroup::class, 'id', 'academic_group_id');
    }
}
