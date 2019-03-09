<?php

namespace App\Http\Controllers;

class InvitesController extends Controller
{
    /**
     * Display a listing of the invites for a user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return auth()->user()->invites;
    }
}
