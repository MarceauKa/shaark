<?php

namespace App\Http\Controllers;

use App\Exports\ChestsExport;
use App\Exports\LinksExport;
use App\Exports\StoriesExport;
use App\Http\Requests\ImportRequest;
use App\Services\Import;
use App\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tags()
    {
        $tags = Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->get();

        return view('manage.tags')->with([
            'page_title' => __('Tags'),
            'tags' => $tags,
        ]);
    }

    public function deleteTag(Request $request, string $tag, string $hash)
    {
        if ($hash != csrf_token()) {
            abort(403);
        }

        $tag = Tag::findNamedOrCreate($tag);
        $tag->delete();

        $this->flash("Le tag \"{$tag->name}\" a été supprimé !", 'success');
        return redirect()->back();
    }

    public function importForm(Request $request)
    {
        return view('manage.import')->with([
            'page_title' => __('Import')
        ]);
    }

    public function importStore(ImportRequest $request)
    {
        try {
            $import = new Import(
                $request->file('file')->getRealPath(),
                [
                    'tags' => $request->has('ignore_tags') ? false : true,
                    'extras' => $request->has('get_extras') ? true : false,
                    'search' => $request->has('refresh_search') ? true : false,
                ]
            );
        } catch (\Exception $e) {
            $this->flash("Impossible d'importer : " . $e->getMessage(), 'error');
            return redirect()->back();
        }

        $result = $import->result();
        $this->flash("Import terminé avec {$result['links_count']} liens et {$result['tags_count']} tags.", 'success');
        return redirect()->back();
    }

    public function exportForm(Request $request)
    {
        return view('manage.export')->with([
            'page_title' => __('Export')
        ]);
    }

    public function export(Request $request)
    {
        $format = $request->get('format');
        $formats = ['xlsx', 'csv'];

        $type = $request->get('type');
        $types = [
            'links' => LinksExport::class,
            'chests' => ChestsExport::class,
            'stories' => StoriesExport::class,
        ];

        if (false === array_key_exists($type, $types)
            || false === in_array($format, $formats)
        ) {
            $this->flash("Type d'export ou format non-reconnu.", 'error');
            return redirect()->back();
        }

        $class = $types[$type];

        return Excel::download(
            new $class,
            "{$type}.{$format}",
            $format == 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
