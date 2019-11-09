<?php

namespace App\Http\Controllers;

use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function robots(Request $request, Shaarli $shaarli)
    {
        $content = "User-agent: *\nDisallow:";

        if (true === $shaarli->getIsPrivate()) {
            $content = "User-agent: *\nDisallow: /";
        }

        return response()->make($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Lenght' => strlen($content),
        ]);
    }
}
