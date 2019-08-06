<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserAvatarsController extends Controller
{
    public function store()
    {
        request()->validate([
            'avatar' => 'required|image|dimensions:max_width=200,max_height=200',
        ]);

        if (auth()->user()->avatar_path !== asset('storage/avatars/default.svg')) {
            Storage::disk('public')->delete(auth()->user()->getOriginal('avatar_path'));
        }

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
