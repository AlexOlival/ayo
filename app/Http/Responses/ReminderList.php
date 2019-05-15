<?php

namespace App\Http\Responses;

use RuntimeException;
use Illuminate\Http\Request;
use App\Constants\ReminderPeriod;
use Illuminate\Contracts\Support\Responsable;

class ReminderList implements Responsable
{
    private $period;

    public function __construct($period)
    {
        $this->period = $period;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return void
     */
    public function toResponse($request)
    {
        switch ($this->period) {
            case ReminderPeriod::UPCOMING:
                $remindersOwned = auth()->user()->reminders()->upcoming()->get();
                $remindersAsGuest = auth()->user()->guestReminders()->upcoming()->get();
                break;
            case ReminderPeriod::NEXT_WEEK:
                $remindersOwned = auth()->user()->reminders()->nextWeek()->get();
                $remindersAsGuest = auth()->user()->guestReminders()->nextWeek()->get();
                break;
            case ReminderPeriod::MONTH:
                $remindersOwned = auth()->user()->reminders()->month()->get();
                $remindersAsGuest = auth()->user()->guestReminders()->month()->get();
                break;
            case ReminderPeriod::LATER:
                $remindersOwned = auth()->user()->reminders()->muchLater()->get();
                $remindersAsGuest = auth()->user()->guestReminders()->muchLater()->get();
                break;
            default:
                throw new RuntimeException("Unknown parameter '$this->period'");
        }

        return $remindersOwned->merge($remindersAsGuest);
    }
}