<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->middleware('throttle:5,1')->only('check');
    }

    public function form()
    {
        return view('auth.login');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard()->attempt($validated, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
