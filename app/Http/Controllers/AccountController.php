<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserAccount;
use App\Http\Requests\UpdateUserPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('demo')->except('form');
    }

    public function form(Request $request)
    {
        return view('account')->with([
            'page_title' => __('Account'),
            'user' => $request->user(),
        ]);
    }

    public function store(UpdateUserAccount $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->fill($validated);
        $user->save();

        $this->flash(__('Your account has been updated!'));
        return redirect()->back();
    }

    public function storePassword(UpdateUserPassword $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->password = Hash::make($validated['new_password']);
        $user->api_token = User::generateApiToken();
        $user->save();

        $this->flash(__('Your password has been updated!'));
        return redirect()->back();
    }
}
