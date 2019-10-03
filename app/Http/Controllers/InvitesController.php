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
        $allInvites = auth()->user()->invites()->with('guests')->get();
        $numberOfInvites = $allInvites->count();
        $invites = $allInvites->take(4);

        return compact('invites', 'numberOfInvites');
    }
}
