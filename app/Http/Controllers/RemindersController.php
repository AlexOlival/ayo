<?php

namespace App\Http\Controllers;

use App\Reminder;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class RemindersController extends Controller
{
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

        $reminder = auth()->user()->reminders()->create(Arr::except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request('guests'));

            $reminder->inviteUsers($guestUserIds);
        }

        return response()->json('created', Response::HTTP_CREATED);
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

        $reminder->update(Arr::except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request('guests'));

            $reminder->inviteUsers($guestUserIds);
        }

        return response()->json('updated', Response::HTTP_OK);
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);

        $reminder->delete();

        return response()->json('deleted', Response::HTTP_OK);
    }
}
