<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class HomepageComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = auth()->user();

        $view->with('userHasInvites', $user->invites()->exists())
            ->with('userHasReminders', $user->reminders()->exists() || $user->guestReminders()->exists());
    }
}
