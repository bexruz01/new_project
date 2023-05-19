<?php

namespace App\Models\Lesson;

use App\Filters\Filterable;
use App\Models\Additional\Week;
use App\Models\Academic\AcademicGroup;
use App\Models\Education\Semester;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSchedule extends Model
{
    use HasFactory, Scopes;

    public function semester() {
        return $this->belongsTo(Semester::class,'semester_id','id');
    }

    public function academic_group() {
        return $this->belongsTo(AcademicGroup::class,'academic_group_id','id');
    }

    public function weeks() {
        return $this->belongsToMany(Week::class,'lesson_schedule_topics','lesson_schedule_id','week_id')->DISTINCT('id');
    }

    // /** Shu semesterdagi haftalar ro'yhati; */
    // public function weekListInSemester() {
    //     return $this->hasMany(Week::class,'semester_id','semester_id');
    // }

    public function lesson_schedule_topics() {
        return $this->hasMany(LessonScheduleTopic::class);
    }

}