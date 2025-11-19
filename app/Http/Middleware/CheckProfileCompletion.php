<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfileCompletion
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Allow ONLY login/logout/profile edit/update while incomplete
        if ($user && !$user->profile_completed) {
            // Block only other pages
            if (
                !$request->routeIs('admin.profile.edit') &&
                !$request->routeIs('admin.profile.update') &&
                !$request->routeIs('logout')
            ) {
                return redirect()->route('admin.profile.edit')
                    ->with('error', 'Please complete your profile to continue.');
            }
        }

        return $next($request);
    }
}
