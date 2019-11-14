<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsRequest;
use App\Services\Shaark\Shaark;
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
            'settings' => app('shaark')->getSettings(),
        ]);
    }

    public function store(StoreSettingsRequest $request, Shaark $shaark)
    {
        $validated = collect($request->validated());

        $shaark
            ->setSettings($validated)
            ->cleanSettings();

        $this->flash(__('Settings updated!'), 'success');
        return redirect()->back();
    }
}
