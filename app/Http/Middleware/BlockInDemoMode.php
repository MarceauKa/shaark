<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockInDemoMode
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (config('shaarli.demo')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => __("This action is unavailable in demo mode")
                ], 401);
            }

            session()->flash('alert', __("This action is not available in demo mode"));
            session()->flash('level', 'info');

            return redirect()->back();
        }

        return $next($request);
    }
}
