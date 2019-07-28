<?php

namespace App\Http\Controllers;

class ExpandedReminderListController extends Controller
{
    public function index()
    {
        $period = request('period');

        $reminders = request()->user()->getAllRemindersFromPeriod($period);

        if (count($reminders) < 5) {
            return redirect('home');
        }

        return view('reminders.paginated', compact('reminders', 'period'));
    }
}
