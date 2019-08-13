<?php

namespace App\Http\Controllers;

use App\Notifications\ReminderDeletedNotification;
use App\Reminder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

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
            'notification_date' => 'required|date|after:' . now(),
            'guests' => 'sometimes|array',
        ]);

        $reminder = auth()->user()->reminders()->create(array_except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request()->get('guests'));

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
            'notification_date' => 'sometimes|required|date|after:' . now(),
            'guests' => 'sometimes|array',
        ]);

        $reminder->update(Arr::except($attributes, 'guests'));

        if (request()->has('guests')) {
            $guestUserIds = array_values(request()->get('guests'));

            $reminder->inviteUsers($guestUserIds);
        }

        return response()->json('updated', Response::HTTP_OK);
    }

    /**
     * Delete a reminder.
     *
     * @param Reminder $reminder
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);

        try {
            DB::beginTransaction();

            $reminder->delete();
            Notification::send($reminder->guests, new ReminderDeletedNotification($reminder));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json('There was an error deleting the reminder', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json('deleted', Response::HTTP_OK);
    }
}
