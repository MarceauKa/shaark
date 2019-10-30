<?php

namespace App\Http\Controllers;

use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;

class PwaController extends Controller
{
    public function manifest(Request $request, Shaarli $shaarli)
    {
        $manifest = [
            'dir' => 'ltr',
            'lang' => $shaarli->getLocale(),
            'name' => $shaarli->getName(),
            'scope' => '/',
            'display' => 'standalone',
            'start_url' => url()->route('home'),
            'short_name' => $shaarli->getName(),
            'theme_color' => 'transparent',
            'description' => $shaarli->getName(),
            'orientation' => 'any',
            'background_color' => 'transparent',
            'related_applications' => '',
            'prefer_related_applications' => 'false',
            'icons' => [],
            'screenshots' => [],
            'generated' => true,
        ];

        $headers = [
            'Content-Type' => 'application/manifest+json',
        ];

        return response()->json($manifest, 200, $headers);
    }

    public function worker(Request $request)
    {
        return response()->file(resource_path('js/sw.js'));
    }

    public function offline(Request $request, Shaarli $shaarli)
    {
        return view('offline')->with([
            'page_title' => $shaarli->getName(),
        ]);
    }
}
