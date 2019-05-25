<?php

namespace App;

use App\Constants\ReminderStatus;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reminder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'notification_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'notification_date' => 'datetime',
    ];

    /**
     * The path to the reminder.
     *
     * @return string
     */
    public function path()
    {
        return "/reminders/$this->id";
    }

    /**
     * The owner of the reminder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The invited users of the reminder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invited()
    {
        return $this->belongsToMany(User::class, 'reminder_guests')
            ->wherePivot('status', ReminderStatus::PENDING)
            ->withPivot('user_id', 'reminder_id', 'status');
    }

    /**
     * The guests of the reminder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany(User::class, 'reminder_guests')
            ->wherePivot('status', ReminderStatus::ACCEPTED)
            ->withPivot('user_id', 'reminder_id', 'status');
    }

    /**
     * All guests and invited users of the reminder.
     *
     * @return Collection
     */
    public function getAllInvitedGuests()
    {
        $guests = $this->guests;

        $invitedUsers = $this->invited;

        return $guests->merge($invitedUsers);
    }

    /**
     * Add new users to the reminder invite list.
     *
     * @param $guestUserIds
     */
    public function inviteUsers(array $guestUserIds)
    {
        $existingGuestUserIds = $this->getAllInvitedGuests()->pluck('id');

        $newGuestIds = collect($guestUserIds)->diff($existingGuestUserIds);

        $this->invited()->attach($newGuestIds);
    }

    /**
     * Get upcoming reminders, aka the current week's reminders
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query)
    {
        $now = now();
        $endOfWeek = now()->endOfWeek();

        return $query
            ->whereBetween('notification_date', [$now, $endOfWeek]);
    }

    /**
     * Get next week's reminders
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNextWeek(Builder $query)
    {
        $startNextWeek = now()->addWeek()->startOfWeek();
        $endNextWeek = now()->addWeek()->endOfWeek();

        return $query
            ->whereBetween('notification_date', [$startNextWeek, $endNextWeek]);
    }

    /**
     * Get this month's reminders
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeMonth(Builder $query)
    {
        $startDate = now()->addWeek()->endOfWeek();
        $endDate = now()->endOfMonth();

        return $query
            ->whereBetween('notification_date', [$startDate, $endDate]);
    }

    /**
     * Get all other reminders
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeMuchLater(Builder $query)
    {
        $startDate = now()->endOfMonth();
        $endDate = now()->addCenturies(5);
        return $query
            ->whereBetween('notification_date', [$startDate, $endDate]);
    }
}
