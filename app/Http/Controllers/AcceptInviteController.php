<?php

namespace App\Http\Controllers;

use App\Reminder;
use App\Constants\ReminderStatus;

class AcceptInviteController extends Controller
{
    /**
     * Accept an invite.
     *
     * @param Reminder $reminder
     * @return void
     */
    public function __invoke(Reminder $reminder)
    {
        $invite = auth()->user()->invites()->where('reminder_id', $reminder->id)->first()->pivot;

        $invite->update(['status' => ReminderStatus::ACCEPTED]);
    }
}
