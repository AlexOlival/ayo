<?php

namespace App\Http\Controllers;

use App\User;

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
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        auth()->logout();

        $user->delete();

        return redirect(route('welcome'));
    }
}
