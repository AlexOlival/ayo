<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display the authenticated user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('profile.show');
    }

    /**
     * Delete the authenticated user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        User::destroy(auth()->id());

        auth()->logout();

        return redirect(route('welcome'));
    }
}
