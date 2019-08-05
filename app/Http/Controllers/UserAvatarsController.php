<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class UserAvatarsController extends Controller
{
    public function store()
    {
        request()->validate([
            'avatar' => 'required|image|dimensions:max_width=200,max_height=200',
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
