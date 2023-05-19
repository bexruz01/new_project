<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingCritery extends Model
{
    use HasFactory;

    protected $table = 'rating_criteries';

    public function critery()
    {
        return $this->hasOne(Critery::class, 'id', 'criteria_id');
    }

    public function publication_type()
    {
        return $this->hasOne(PublicationType::class, 'id', 'publication_type_id');
    }
}