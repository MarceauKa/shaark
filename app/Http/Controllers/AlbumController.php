<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        return view('form-album')->with([
            'page_title' => __('Add album'),
            'album' => null,
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $album = Album::with('post.tags')->findOrFail($id);

        return view('form-album')->with([
            'page_title' => __('Update album'),
            'album' => $album,
        ]);
    }
}
