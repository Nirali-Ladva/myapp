<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->is_admin && !$user->profile_completed) {
            $allowed = [
                'admin.profile.edit',
                'admin.profile.update',
                'logout',
                'login',
                'login.post'
            ];
            $routeName = $request->route() ? $request->route()->getName() : null;
            if (!in_array($routeName, $allowed)) {
                return redirect()->route('admin.profile.edit')
                    ->with('error', 'Please complete your profile before proceeding.');
            }
        }
        return $next($request);
    }
}
