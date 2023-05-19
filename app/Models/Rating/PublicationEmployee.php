<?php

namespace App\Models\Rating;

use App\Models\Additional\WorkContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationEmployee extends Model
{
    use HasFactory;

    protected $table = 'publication_employees';

    public function publication()
    {
        return $this->hasOne(Publication::class, 'id', 'publication_id');
    }

    public function employee()
    {
        return $this->hasOne(WorkContract::class, 'employee_id', 'employee_id');
    }

    public function rating_critery()
    {
        return $this->hasOne(RatingCritery::class, 'id', 'rating_criteria_id');
    }
}
