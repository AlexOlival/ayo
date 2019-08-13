<?php

namespace App\Http\Middleware;

use App\Reminder;
use Closure;
use Illuminate\Support\Facades\Response;

class ReminderIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $reminder = Reminder::findOrFail($request->reminder->id);

        if ($reminder === null) {
            $error = (object) [
                'code' => 'invalidReminder',
                'status' => '404',
                'title' => 'Invalid Reminder',
                'detail' => 'Reminder id provided in URL is not a valid',
                'source' => (object) ['paramenter' => 'reminder_id'],
            ];

            if ($request->route()->getPrefix() === 'api') {
                return response()->json(['errors' => [$error]], Response::HTTP_NOT_FOUND);
            }
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
