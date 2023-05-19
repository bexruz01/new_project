<?php

namespace App\Models\Curriculum;

use App\Models\Exam\ExamType;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumExamType extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    /** Imtihon turini olish; */
    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id', 'id');
    }
}