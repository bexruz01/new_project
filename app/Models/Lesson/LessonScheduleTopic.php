<?php

namespace App\Models\Lesson;

use App\Models\Additional\Audience;
use App\Models\Additional\Week;
use App\Models\Education\Pair;
use App\Models\Education\Subject;
use App\Models\Education\SubjectTopic;
use App\Models\User\Employee;
use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonScheduleTopic extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function lesson_schedule()
    {
        return $this->hasOne(LessonSchedule::class, 'id', 'lesson_schedule_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function audience()
    {
        return $this->hasOne(Audience::class, 'id', 'audience_id');
    }

    public function subject_topic()
    {
        return $this->hasOne(SubjectTopic::class, 'subject_id', 'subject_id');
    }

    /** Shu dars jadvaliga tegishli hodimni olish; */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function lesson_activity()
    {
        return $this->hasOne(LessonActivity::class, 'id', 'lesson_activity_id');
    }

    /** Juftlikni olish; */
    public function pair()
    {
        return $this->hasOne(Pair::class, 'id', 'pair_id');
    }

    public function week()
    {
        return $this->belongsTo(Week::class, 'week_id', 'id');
    }

    // public function weeks() {
    //     return DB::table('lesson_schedule_topics')
    //         ->select('position', DB::raw('COUNT(*)'))
    //         ->leftJoin('weeks', 'weeks.id', '=', 'lesson_schedule_topics.week_id')
    //         ->where('lesson_schedule_id', $this->id)
    //         ->groupBy('weeks.id')->get();
    // }
}