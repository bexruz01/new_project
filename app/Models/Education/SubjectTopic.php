<?php

namespace App\Models\Education;

use App\Traits\Scopes;
use App\Traits\HasTranslations;
use App\Models\Curriculum\Curriculum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectTopic extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function subject_topic_resources()
    {
        return $this->hasMany(SubjectTopicResource::class,'subject_topic_id','id');
    }

    public function curriculum()
    {
        return $this->hasOne(Curriculum::class,'id','curriculum_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class,'id','subject_id');
    }
}