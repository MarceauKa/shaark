<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageAccess
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => __("You can't access settings section")
            ], 401);
        }

        session()->flash('alert', __("You can't access settings section"));
        session()->flash('level', 'error');

        return redirect()->back();
    }
}
