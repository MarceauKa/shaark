<?php

namespace App\Http\Controllers;

use App\Events\LinkArchiveRequested;
use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkActionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updatePreview(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);
        $link->updatePreview();

        $this->flash(__('Link preview has been updated', ['name' => $link->title]), 'success');
        return redirect()->back();
    }

    public function createArchive(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);
        event(new LinkArchiveRequested($link));

        $this->flash(__('Link is being archived'), 'success');
        return redirect()->back();
    }

    public function downloadArchive(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);
        $file = $link->archive;

        if ($link->hasArchive() && Storage::disk('archives')->exists($file))
        {
            return Storage::disk('archives')->download($file);
        }

        $this->flash(__('Link archive doest not exist', 'error'));
        return redirect()->back();
    }
}
