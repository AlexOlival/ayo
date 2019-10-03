<?php

namespace App\Http\Controllers;

class ExpandedInviteListController extends Controller
{
    public function index()
    {
        $invites = request()->user()->invites;

        if (count($invites) < 5) {
            return redirect('home');
        }

        return view('invites.paginated', compact('invites'));
    }
}
