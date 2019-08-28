<?php

namespace App\Http\Controllers;

use App\Chest;
use Illuminate\Http\Request;

class ChestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        return view('form-chest')->with([
            'page_title' => __('Add chest'),
            'submit' => route('api.chest.store'),
            'method' => 'POST',
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $chest = Chest::with('post.tags')->findOrFail($id);

        return view('form-chest')->with([
            'page_title' => __('Update chest'),
            'submit' => route('api.chest.update', $id),
            'method' => 'PUT',
            'chest' => $chest,
        ]);
    }

    public function delete(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Chest $link */
        $chest = Chest::with('post')->findOrFail($id);

        $chest->post->delete();
        $chest->delete();

        $this->flash(__('Chest :name has been deleted', ['name' => $chest->title]), 'success');
        return redirect()->back();
    }
}
