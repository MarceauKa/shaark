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
            'start_url' => '/',
            'short_name' => $shaarli->getName(),
            'theme_color' => 'transparent',
            'description' => $shaarli->getName(),
            'orientation' => 'any',
            'background_color' => 'transparent',
            'prefer_related_applications' => false,
            'icons' => [
                [
                    'src' => $shaarli->getCustomIconUrl(),
                    'type' => 'image/png',
                    'sizes' => '192x192 512x512',
                ]
            ],
            'serviceworker' => [
                'src' => url('serviceworker.js'),
            ],
            'generated' => true,
        ];

        $headers = [
            'Content-Type' => 'application/manifest+json',
        ];

        return response()->json($manifest, 200, $headers);
    }

    public function worker(Request $request)
    {
        return response()->file(resource_path('js/sw.js'), [
            'Content-Type' => 'application/javascript'
        ]);
    }

    public function offline(Request $request, Shaarli $shaarli)
    {
        return view('offline')->with([
            'page_title' => $shaarli->getName(),
        ]);
    }
}
