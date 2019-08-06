<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
