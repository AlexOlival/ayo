<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user)
    {
        return auth()->user()->is($user);
    }
}
