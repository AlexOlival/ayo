<?php

namespace App\Http\Controllers;

use App\Reminder;
use \Symfony\Component\HttpFoundation\Response as ResponseStatusCodes;

class RemindersController extends Controller
{
    /**
     * Create a new reminder in the database.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
