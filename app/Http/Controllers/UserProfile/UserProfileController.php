<?php

namespace App\Http\Controllers\UserProfile;

use App\Services\UserProfile\UserProfileService;
use App\Http\Requests\Users\UserProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show()
    {
        return UserProfileService::getInstance()->show();
    }

    public function update(UserProfileRequest $request)
    {
        return UserProfileService::getInstance()->update($request);
    }
}