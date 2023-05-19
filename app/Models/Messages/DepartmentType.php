<?php

namespace App\Models\Messages;

use App\Traits\HasTranslations;
use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentType extends Model
{
    use HasFactory, Scopes, HasTranslations;

    public array $translatable = ['name'];
    protected $table = "department_types";

    protected $fillable = ['type'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
