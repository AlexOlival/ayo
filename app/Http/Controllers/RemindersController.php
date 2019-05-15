<?php

namespace App\Http\Controllers;

use App\Reminder;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\ReminderList;
use Illuminate\Auth\Access\AuthorizationException;
use \Symfony\Component\HttpFoundation\Response as ResponseStatusCodes;

class RemindersController extends Controller
{
    /**
     * Display a listing of the reminders for a user.
     *
     * @return ReminderList
     */
    public function index()
    {
        return new ReminderList(request('period'));
    }

    /**
     * Create a new reminder in the database.
     *
     * @return JsonResponse
     */
    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:300',
            'notification_date' => 'required|date|after:'.now(),
            'guests' => 'sometimes|array',
        ]);

        $reminder = auth()->user()->reminders()->create(array_except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request()->get('guests'));

            $reminder->inviteUsers($guestUserIds);
        }

        return response()->json('created', ResponseStatusCodes::HTTP_CREATED);
    }

    /**
     * Update a reminder.
     *
     * @param Reminder $reminder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Reminder $reminder)
    {
        $this->authorize('update', $reminder);

        $attributes = request()->validate([
            'title' => 'sometimes|required|string|max:50',
            'description' => 'sometimes|nullable|string|max:300',
            'notification_date' => 'sometimes|required|date|after:'.now(),
            'guests' => 'sometimes|array',
        ]);

        $reminder->update(array_except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request()->get('guests'));

            $reminder->inviteUsers($guestUserIds);
        }

        return response()->json('updated', ResponseStatusCodes::HTTP_OK);
    }
}
