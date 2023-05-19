<?php

namespace App\Models\Academic;

use App\Models\Curriculum\Curriculum;
use App\Models\Curriculum\CurriculumAudianceHour;
use App\Models\Education\Subject;
use App\Models\Lesson\LessonScheduleTopic;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicGroupSubject extends Model
{
    use HasFactory, Scopes;

    public function lesson_schedule_topics()
    {
        return $this->hasMany(LessonScheduleTopic::class, 'subject_id', 'subject_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function academic_group()
    {
        return $this->belongsTo(AcademicGroup::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function curriculum_audiance_hourses()
    {
        return $this->hasMany(CurriculumAudianceHour::class, 'curriculum_id', 'curriculum_id');
    }
}