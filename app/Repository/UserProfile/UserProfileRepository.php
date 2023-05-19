<?php

namespace App\Repository\UserProfile;

use App\Models\User;
use Closure;

class UserProfileRepository
{
    public static function getInstance()
    {
        return new static();
    }

    public function user(Closure $closure)
    {
        return $closure(User::query())
            ->first();
    }
}