<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginsController extends Controller
{
    public function purge(Request $request)
    {
        DB::table('logins')->truncate();
        DB::table('devices')->truncate();

        return response()->json([
            'status' => 'purged',
        ]);
    }
}
