<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsRequest;
use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('form');
    }

    public function form(Request $request)
    {
        return view('manage.settings')->with([
            'page_title' => __('Settings'),
            'settings' => app('shaarli')->getSettings(),
        ]);
    }

    public function store(StoreSettingsRequest $request, Shaarli $shaarli)
    {
        $validated = collect($request->validated());
        $shaarli->setSettings($validated);

        $this->flash(__('Settings updated!'), 'success');
        return redirect()->back();
    }
}
