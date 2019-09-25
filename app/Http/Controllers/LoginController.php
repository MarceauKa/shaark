<?php

namespace App\Http\Controllers;

use App\Notifications\SecureLoginCode;
use App\SecureLogin;
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
        return view('login');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard()->attempt($validated, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (true === app('shaarli')->getSecureLogin()) {
                $user = Auth::guard()->user();
                $secure = SecureLogin::createForUser($user);
                $user->notify(new SecureLoginCode($secure));
                Auth::logout();

                return redirect()->route('login.secure', $secure);
            }

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => [__("Invalid credentials")],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
