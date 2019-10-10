<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function all()
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        $validated = collect($request->validated());

        $user = new User($validated->only([
            'name',
            'email'
        ])->toArray());

        $user->password = Hash::make($validated->get('password'));
        $user->api_token = User::generateApiToken();
        $user->is_admin = $validated->get('is_admin', false);
        $user->save();

        return response()->json([
            'status' => 'created',
            'id' => $user->id,
        ]);
    }

    public function delete(Request $request, int $id)
    {
        if ($request->user()->id == $id) {
            return response()->json([
               'status' => 'error',
               'message' => __("Can't delete the user you're logged in"),
            ], 422);
        }

        $user = User::findOrFail($id);
        $user->delete();

        Post::where('user_id', $id)->delete();

        return response()->json([
            'status' => 'deleted',
            'id' => $id,
        ]);
    }
}
