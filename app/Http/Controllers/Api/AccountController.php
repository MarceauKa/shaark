<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:api',
            'demo'
        ]);
    }

    public function purge(Request $request)
    {
        DB::table('logins')
            ->where(['user_id' => $request->user()->id])
            ->delete();

        DB::table('devices')
            ->where(['user_id' => $request->user()->id])
            ->delete();

        return response()->json([
            'status' => 'purged',
        ]);
    }
}
