<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DirectionMeddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('lang'))
            App::setLocale($request->header('lang'));
        $user = Auth::user();
        $roles_count = UserRole::query()->where('user_id', $user->id)->with('role')
            ->whereHas('role', function ($q) {
                $q->whereIn('key', ['direction']); //'super_admin',
            })->count();
        if ($roles_count > 0) {
            if ($user->status == 'inactive' || $user->status == 'blocked') {
                return response()->json(['errors' => ['Not authorized.', 403]]);
            }
            return $next($request);
        }
        return response()->json(['errors' => ['Not authorized.', 403]]);
    }
}
