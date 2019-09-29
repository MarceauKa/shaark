<?php

namespace App\Http\Controllers;

use App\Events\LinkArchiveRequested;
use App\Link;
use App\Services\LinkArchive\LinkArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LinkArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except('download');
    }

    public function form(Request $request, int $id)
    {
        /** @var Link $link */
        $link = Link::findOrFail($id);

        return view('link-archive')->with([
            'page_title' => __('Manage archive'),
            'providers' => LinkArchive::availableFor($link->url),
            'link' => $link,
        ]);
    }

    public function store(Request $request, int $id)
    {
        /** @var Link $link */
        $link = Link::findOrFail($id);
        event(new LinkArchiveRequested($link, $request->get('type')));

        $this->flash(__('Link is being archived'), 'success');
        return redirect()->away($link->permalink);
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

    public function delete(Request $request, int $id)
    {
        /** @var Link $link */
        $link = Link::findOrFail($id);

        $file = $link->archive;

        if ($file && Storage::disk('archives')->exists($file)) {
            Storage::disk('archives')->delete($file);
            $link->archive = null;
            $link->save();

            $this->flash(__('Archive has been deleted'), 'success');
            return redirect()->back();
        }

        $this->flash(__('Archive doest not exist'), 'error');
        return redirect()->back();
    }
}
