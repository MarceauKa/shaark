<?php

namespace App\Http\Controllers;

use App\Exports\ChestsExport;
use App\Exports\LinksExport;
use App\Exports\StoriesExport;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\StoreSettingsRequest;
use App\Services\Import;
use App\Services\Shaarli\Shaarli;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lab404\AuthChecker\Models\Login;
use Maatwebsite\Excel\Facades\Excel;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except([
            'importForm',
            'exportForm',
            'settingsForm',
            'tags',
        ]);
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

    public function settingsForm(Request $request)
    {
        return view('manage.settings')->with([
            'page_title' => __('Settings'),
            'settings' => app('shaarli')->getSettings(),
        ]);
    }

    public function settingsStore(StoreSettingsRequest $request, Shaarli $shaarli)
    {
        $validated = collect($request->validated());
        $shaarli->setSettings($validated);

        $this->flash(__('Settings updated!'), 'success');
        return redirect()->back();
    }

    public function logins(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $logins = Login::where('user_id', $user->id)->latest()->paginate(25);

        return view('manage.logins')->with([
            'logins' => $logins,
            'page_title' => __('Logins'),
        ]);
    }

    public function logoutDevices(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::guard('web')->logoutOtherDevices($validated['password']);

        $user = $request->user();
        $user->api_token = User::generateApiToken();
        $user->save();

        $this->flash(__("Other sessions have been logged out"), 'success');
        return redirect()->back();
    }

    public function tags()
    {
        return view('manage.tags')->with([
            'page_title' => __('Tags'),
        ]);
    }
}
