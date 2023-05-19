<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson\LessonActivity;
use App\Traits\HasTranslations;
use App\Traits\Scopes;

class CurriculumAudianceHour extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    /** Activ bo'lgan mashg'ulotni olish; */
    public function lesson_activity()
    {
        return $this->belongsTo(LessonActivity::class, 'lesson_activity_id', 'id');
    }
}