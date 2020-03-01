<?php

namespace App\Http\Controllers;

use App\Services\Shaark\Shaark;
use Illuminate\Http\Request;

class PwaController extends Controller
{
    public function manifest(Request $request, Shaark $shaark)
    {
        $manifest = [
            'version' => Shaark::VERSION,
            'dir' => 'ltr',
            'lang' => $shaark->getLocale(),
            'name' => $shaark->getName(),
            'scope' => '/',
            'display' => 'standalone',
            'start_url' => '/',
            'short_name' => $shaark->getName(),
            'theme_color' => 'transparent',
            'description' => $shaark->getName(),
            'orientation' => 'any',
            'background_color' => 'transparent',
            'prefer_related_applications' => false,
            'icons' => [
                [
                    'src' => $shaark->getCustomIconUrl(),
                    'type' => 'image/png',
                    'sizes' => '192x192 512x512',
                ]
            ],
            'share_target' => [
                'action' => route('link.create'),
                'params' => [
                    'url' => 'text',
                ]
            ],
            'serviceworker' => [
                'src' => route('pwa.worker'),
            ],
            'generated' => true,
        ];

        $headers = [
            'Content-Type' => 'application/json',
        ];

        return response()->json($manifest, 200, $headers);
    }

    public function worker(Request $request)
    {
        return response()->file(resource_path('js/sw.js'), [
            'Content-Type' => 'application/javascript'
        ]);
    }

    public function offline(Request $request, Shaark $shaark)
    {
        return view('offline')->with([
            'page_title' => $shaark->getName(),
        ]);
    }
}
