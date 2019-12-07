<?php

namespace App\Policies;

use App\User;
use App\Reminder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reminder $reminder)
    {
        return $user->is($reminder->owner);
    }

    public function delete(User $user, Reminder $reminder)
    {
        return $user->is($reminder->owner);
    }
}
