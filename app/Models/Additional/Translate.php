<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    use HasFactory;
    protected $table = 'translates';

    public function translatable()
    {
        return $this->morphTo();
    }
}
