<?php

namespace App\Models\Curriculum;

use App\Models\Additional\Department;
use App\Models\Education\Subject;
use App\Models\Education\SubjectTask;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumSubject extends Model
{
    use HasFactory, Scopes;

    protected $table = 'curriculum_subjects';

    /** O'quv dasturni olish; */
    public function curriculum()
    {
        return $this->hasOne(Curriculum::class, 'id', 'curriculum_id');
    }

    /** Fanni olish; */
    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    /** Fakultetni olish; */
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id')
            ->where('type', 'department');
    }

    public function subject_tasks()
    {
        return $this->hasMany(SubjectTask::class, 'curriculum_subject_id', 'id');
    }
}