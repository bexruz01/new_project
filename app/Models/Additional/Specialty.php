<?php

namespace App\Models\Additional;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    public $table = 'specialties';

    use HasFactory, Scopes, HasTranslations;

    /** Mutaxasislikka tegishli ta'lim turlarini olish; */
    public function edu_type()
    {
        return $this->hasOne(Reference::class, 'id', 'edu_type_id');
    }

    /** Mutaxasislik turini olish; */
    public function gov_specialty()
    {
        return $this->hasOne(GovSpecialty::class, 'id', 'gov_specialty_id');
    }

    public function type()
    {
        return $this->hasOne(Reference::class, 'id', 'type_id')
            ->where('table_name', 'specialty-types');
    }
}