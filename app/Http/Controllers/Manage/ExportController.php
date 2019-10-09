<?php

namespace App\Http\Controllers\Manage;

use App\Exports\ChestsExport;
use App\Exports\LinksExport;
use App\Exports\StoriesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('form');
    }

    public function form(Request $request)
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
            $this->flash(__('Export type or format not recognized'), 'error');
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
