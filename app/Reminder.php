<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            ->wherePivot('status', ReminderGuest::PENDING)
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
            ->wherePivot('status', ReminderGuest::ACCEPTED)
            ->withPivot('user_id', 'reminder_id', 'status');
    }

    /**
     * All guests and invited users of the reminder.
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
    public function inviteNewUsers(array $guestUserIds)
    {
        $existingGuestUserIds = $this->getAllInvitedGuests()->pluck('id');

        $newGuestIds = collect($guestUserIds)->diff($existingGuestUserIds);

        $this->invited()->attach($newGuestIds);
    }
}
