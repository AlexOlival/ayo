<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;

class Homepage implements Responsable
{
    private $reminders;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return void
     */
    public function toResponse($request)
    {
        $remindersOwned = $request->user()->reminders;
        $remindersWhereGuest = $request->user()->guestReminders;
        $this->reminders = $remindersOwned->merge($remindersWhereGuest);

        $upcomingReminderCount = $this->getRemindersCount(now(), now()->endOfWeek());
        $upcomingReminders = $this->getRemindersFromRange(now(), now()->endOfWeek());

        $startOfNextWeek = now()->addWeek()->startOfWeek();
        $endOfNextWeek = now()->addWeek()->endOfWeek();

        $nextWeekReminderCount = $this->getRemindersCount($startOfNextWeek, $endOfNextWeek);
        $nextWeekReminders = $this->getRemindersFromRange($startOfNextWeek, $endOfNextWeek);

        $endOfMonth = now()->addWeek()->endOfWeek();
        $endDate = now()->addCentury();

        $laterReminderCount = $this->getRemindersCount($endOfMonth, $endDate);
        $laterReminders = $this->getRemindersFromRange($endOfMonth, $endDate);

        return view(
            'home',
            compact(
                'upcomingReminders',
                'upcomingReminderCount',
                'nextWeekReminders',
                'nextWeekReminderCount',
                'laterReminders',
                'laterReminderCount'
            )
        );
    }

    private function getRemindersFromRange($start, $end)
    {
        return $this->reminders
            ->filter(function ($reminder) use ($start, $end) {
                return $reminder->notification_date > $start && $reminder->notification_date <= $end;
            })
            ->take(4);
    }

    private function getRemindersCount($start, $end)
    {
        return $this->reminders
            ->filter(function ($reminder) use ($start, $end) {
                return $reminder->notification_date > $start && $reminder->notification_date <= $end;
            })
            ->count();
    }
}
