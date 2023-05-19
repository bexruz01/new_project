<?php

namespace App\Services\UserProfile;

use App\Http\Resources\UserProfile\UserProfileResource;
use App\Repository\UserProfile\UserProfileRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Employee;
use App\Traits\ApiResponse;
use App\Models\User;

class UserProfileService
{
    use ApiResponse;

    protected $repository;

    public function __construct(UserProfileRepository $repo)
    {
        return $this->repository = $repo;
    }

    public static function getInstance(): UserProfileService
    {
        return new static(UserProfileRepository::getInstance());
    }

    public function show()
    {
        $result = $this->repository->user(function (Builder $builder) {
            return $builder->where('id', auth()->user()->id)
                ->with('employee');
        });
        return $this->successResponse(new UserProfileResource($result));
    }


    public function update($request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if ($request->get('language_id', false)) {
            $user->language_id = $request->language_id;
            $user->save();
        }

        if ($request->password and $request->password_confirm)
            if ($request->password == $request->password_confirm) {
                $user->password = Hash::make($request->password);
                $user->save();
            } else
                return $this->errorResponse(__('message.Not found'));

        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        if ($request->image and $request->hasFile('image')) {
            $fileName = $employee->id . '_direction_' . generateRandomString(15) . '.jpg';
            imageSaved($request->image, $fileName, 'employee', $employee->image);
            $employee->image = $fileName;
        }
        $employee->save();

        return $this->successResponse(new UserProfileResource($user));
    }
}