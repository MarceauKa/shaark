<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LinkArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('demo');
    }

    public function download(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);

        if (false === $link->canDownloadArchive()) {
            abort(404);
        }

        $file = $link->archive;

        if ($file && Storage::disk('archives')->exists($file)) {
            return Storage::disk('archives')->download($file, sprintf('%s-%s', Str::slug($link->title), $file));
        }

        $this->flash(__('Link archive doest not exist', 'error'));
        return redirect()->back();
    }
}
