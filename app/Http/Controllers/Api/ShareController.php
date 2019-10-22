<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShareResource;
use App\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get(Request $request, int $post_id)
    {
        $shares = Share::postIs($post_id)->get();

        return response()->json([
            'shares' => ShareResource::collection($shares),
        ]);
    }

    public function store(Request $request)
    {

    }
}
