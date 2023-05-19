<?php

namespace App\Models\Additional;

use App\Models\Exam\ExamScheduleSubject;
use App\Models\Lesson\LessonScheduleTopic;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory, Scopes, HasTranslations;


    protected $table = "audiences";
    protected $fillable = ['audience_type_id', 'capacity', 'status', 'building_id'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }


    public function exam_schedule_subjects()
    {
        return $this->hasMany(ExamScheduleSubject::class, 'audience_id')
            ->orderBy('date');
    }


    public function lesson_schedule_topics()
    {
        return $this->hasMany(LessonScheduleTopic::class, 'audience_id')
            ->orderBy('date');
    }

    public function audience_type()
    {
        return $this->belongsTo(Reference::class)
            ->where('table_name', 'audience-types');
    }
}