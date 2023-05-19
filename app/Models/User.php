<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\User\Employee;
use App\Models\Role;

/**
 * Class Users
 * @package App\Models
 * @property int  $id
 * @property string  $username
 * @property string  $password
 * @property string $status
 * @property int $language_id
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }


    public function role()
    {
        return $this->hasOne(UserRole::class, 'user_id', 'id')
            ->whereHas('role', function ($query) {
                $query->where('key', 'direction');
            });
    }
}