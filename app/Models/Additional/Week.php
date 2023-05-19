<?php

namespace App\Models\Additional;

use App\Models\Education\Semester;
use App\Models\Lesson\LessonScheduleTopic;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Week extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /** Shu haftadagi darslarini olish; */
    public function lessons()
    {
        return $this->hasMany(LessonScheduleTopic::class, 'week_id', 'id');
    }

    // public function lesson_schedule_topics(){
    //     return $this->hasMay()
    // }
}