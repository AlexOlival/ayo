<?php

namespace App\Http\Controllers;

use App\Http\Responses\Homepage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Homepage
     */
    public function index()
    {
        return new Homepage();
    }
}
