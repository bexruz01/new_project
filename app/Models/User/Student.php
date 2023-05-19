<?php

namespace App\Models\User;

use App\Filters\Filterable;
use App\Models\Academic\AcademicGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Additional\Department;
use App\Models\Additional\District;
use App\Models\Additional\Reference;
use App\Models\Additional\Region;
use App\Models\Additional\Specialty;
use App\Models\Attendance\StudentAttendance;
use App\Models\Education\Semester;
use App\Models\Education\Subject;
use App\Models\Exam\ExamScheduleResult;
use App\Models\Exam\ExamStudent;
use App\Traits\Scopes;

class Student extends Model
{
    use HasFactory, Scopes, Filterable;

    public function getImageAttribute($value)
    {
        return getImageOriginal('students/image', $value);
    }

    /** Studentga tegishli fakultetni olish; */
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'faculty_id')->where('type', 'faculty');
    }
    public function faculty()
    {
        return $this->hasOne(Department::class, 'id', 'faculty_id')->where('type', 'faculty');
    }

    /** Studentga tegishli mutaxasislikni olish; */
    public function specialty()
    {
        return $this->hasOne(Specialty::class, 'id', 'specialty_id');
    }

    /** Studentga tegishli guruhni, o'qub rejasi bilan olish; */
    public function academic_group()
    {
        return $this->hasOne(AcademicGroup::class, 'id', 'academic_group_id');
    }

    /** Studentga tegishli to'lov turini qaytarish; */
    public function payment_type()
    {
        return $this->hasOne(Reference::class, 'id', 'payment_type_id');
    }

    /** Student tegishli semesterni olish funksiyasi; */
    public function semester()
    {
        return $this->hasOne(Semester::class, 'id', 'semester_id');
    }

    /** Studentning viloyatini olish funksiyasi; */
    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    /** Studentning tumanini olish funksiyasi; */
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    /** Studentning yashash joyini olish funksiyasi; */
    public function live_place()
    {
        return $this->hasOne(Reference::class, 'id', 'live_place_id');
    }

    /** Studentning yashash joyini olish funksiyasi; */
    public function social_category()
    {
        return $this->hasOne(Reference::class, 'id', 'social_category_id');
    }

    /** Yo'qlamalar ro'yhati; */
    public function student_attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'student_id', 'id');
    }

    /** Studentning fanlarini olish; */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subjects', 'student_id', 'subject_id')
            ->orderBy('name');
    }


    /** Studentning imtihon natijalarini olish; */
    public function exam_schedule_results()
    {
        return $this->hasMany(ExamScheduleResult::class, 'student_id', 'id');
    }

    public function student_contract()
    {
        return $this->hasOne(StudentContract::class, 'id', 'student_id')->latest();
    }

    public function student_exams()
    {
        return $this->hasMany(ExamStudent::class, 'student_id');
    }

    //  Accessors
    public function getFullNameAttribute(): string
    {
        return implode(' ', [$this->surname, $this->name, $this->last_name]);
    }

    // /** Statistikalarni hisoblash uchun funksiyalar; */

    // public function isMale(){
    //     return $this->gender == 'male';
    // }

    // public function isGrand(){
    //     return optional($this->payment_type)->code == 12;
    // }

    // public function isCourse($nomer){
    //     return $this->semester->course == $nomer;
    // }

    // public function isSpecialty($id) {
    //     return $this->specialty_id == $id;
    // }

    // public function isNation($id) {
    //     return $this->nation_id == $id;
    // }

    // public function isRegion($id) {
    //     return $this->region_id == $id;
    // }

    // public function isEduForm($id) {
    //     return $this->semester->eduPlan->edu_form_id == $id;
    // }

}