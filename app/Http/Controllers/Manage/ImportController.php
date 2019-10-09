<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Services\Import;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('form');
    }

    public function form(Request $request)
    {
        return view('manage.import')->with([
            'page_title' => __('Import')
        ]);
    }

    public function import(ImportRequest $request)
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
}
