<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;

class Homepage implements Responsable
{
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
        $reminders = $remindersOwned->merge($remindersWhereGuest);

        $upcomingReminderCount = $reminders
            ->filter(function ($reminder) {
                return $reminder->notification_date > now() && $reminder->notification_date <= now()->endOfWeek();
            })
            ->count();
        $upcomingReminders = $reminders
            ->filter(function ($reminder) {
                return $reminder->notification_date > now() && $reminder->notification_date <= now()->endOfWeek();
            })
            ->take(4);

        $startOfNextWeek = now()->addWeek()->startOfWeek();
        $endOfNextWeek = now()->addWeek()->endOfWeek();

        $nextWeekReminderCount = $reminders
            ->filter(function ($reminder) use ($startOfNextWeek, $endOfNextWeek) {
                return $reminder->notification_date > $startOfNextWeek
                    && $reminder->notification_date <= $endOfNextWeek;
            })->count();
        $nextWeekReminders = $reminders
            ->filter(function ($reminder) use ($startOfNextWeek, $endOfNextWeek) {
                return $reminder->notification_date > $startOfNextWeek
                    && $reminder->notification_date <= $endOfNextWeek;
            })
            ->take(4);

        $startTime = now()->addWeek()->endOfWeek();
        $endOfMonth = now()->endOfMonth();

        $monthReminderCount = $reminders
            ->filter(function ($reminder) use ($startTime, $endOfMonth) {
                return $reminder->notification_date > $startTime
                    && $reminder->notification_date <= $endOfMonth;
            })
            ->count();
        $monthReminders = $reminders
            ->filter(function ($reminder) use ($startTime, $endOfMonth) {
                return $reminder->notification_date > $startTime
                    && $reminder->notification_date <= $endOfMonth;
            })
            ->take(4);

        $endOfMonth = now()->endOfMonth();
        $endDate = now()->addCentury();

        $laterReminderCount = $reminders
            ->filter(function ($reminder) use ($endOfMonth, $endDate) {
                return $reminder->notification_date > $endOfMonth
                    && $reminder->notification_date <= $endDate;
            })
            ->count();
        $laterReminders = $reminders
            ->filter(function ($reminder) use ($endOfMonth, $endDate) {
                return $reminder->notification_date > $endOfMonth
                    && $reminder->notification_date <= $endDate;
            })
            ->take(4);

        return view(
            'home',
            compact(
                'upcomingReminders',
                'upcomingReminderCount',
                'nextWeekReminders',
                'nextWeekReminderCount',
                'monthReminders',
                'monthReminderCount',
                'laterReminders',
                'laterReminderCount'
            )
        );
    }
}
