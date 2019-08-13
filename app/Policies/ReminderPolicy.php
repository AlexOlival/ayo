<?php

namespace App\Policies;

use App\Reminder;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reminder $reminder)
    {
        return $user->is($reminder->owner);
    }

    /**
     * Determine whether the user can delete the reminder.
     *
     * @param  \App\User  $user
     * @param  \App\Reminder  $reminder
     * @return mixed
     */
    public function delete(User $user, Reminder $reminder)
    {
        return $user->is($reminder->owner);
    }
}
