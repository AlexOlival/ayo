<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $avatar = $user->getOriginal('avatar_path');
        if (Storage::disk('public')->exists($avatar)) {
            Storage::disk('public')->delete($avatar);
        }
    }
}
