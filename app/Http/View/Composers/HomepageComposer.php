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
        $view->with('userHasInvites', auth()->user()->invites()->exists())
            ->with('userHasReminders', auth()->user()->reminders()->exists());
    }
}
