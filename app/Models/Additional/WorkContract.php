<?php

namespace App\Models\Additional;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkContract extends Model
{
    use HasFactory, HasTranslations, Scopes;

    public array $translatable = ['name'];

    public function getNameAttribute($value)
    {
        return $this->translate('name') ?? $value;
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}