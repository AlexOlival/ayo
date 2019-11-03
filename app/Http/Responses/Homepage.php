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

        $upcomingReminderCount = $this->getRemindersCount(now(), now()->addDays(3));
        $upcomingReminders = $this->getRemindersFromRange(now(), now()->addDays(3));

        $fiveDaysFromNow = now()->addDays(3);
        $tenDaysAfter = now()->addDays(13);

        $tenDaysAfterReminderCount = $this->getRemindersCount($fiveDaysFromNow, $tenDaysAfter);
        $tenDaysAfterReminders = $this->getRemindersFromRange($fiveDaysFromNow, $tenDaysAfter);

        $startDate = now()->addDays(13);
        $endDate = now()->addCentury();

        $laterReminderCount = $this->getRemindersCount($startDate, $endDate);
        $laterReminders = $this->getRemindersFromRange($startDate, $endDate);

        return view(
            'home',
            compact(
                'upcomingReminders',
                'upcomingReminderCount',
                'tenDaysAfterReminders',
                'tenDaysAfterReminderCount',
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
