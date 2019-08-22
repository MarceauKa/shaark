<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Link;
use App\Services\WebParser;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function parse(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        $parser = WebParser::parse($request->get('url'));

        return response()->json([
            'title' => $parser->title,
            'content' => $parser->content,
        ]);
    }

    public function store(StoreLinkRequest $request)
    {
        $data = $request->validated();
        $link = Link::create($data);
        $link->findExtra();

        return response()->json([
            'id' => $link->id,
            'status' => 'created',
        ]);
    }
}
