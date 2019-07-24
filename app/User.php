<?php

namespace App;

use App\Constants\ReminderStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Search for users, excluding the authenticated user itself
     *
     * @param Builder $query
     * @param string $username
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $username)
    {
        return $query
            ->select('id', 'username')
            ->whereNotIn('id', [auth()->id()])
            ->where('username', 'LIKE', "{$username}%");
    }

    /**
     * The user's reminders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'owner_id')->with('guests');
    }

    /**
     * The reminders to which the user is invited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invites()
    {
        return $this->belongsToMany(Reminder::class, 'reminder_guests')
            ->using(ReminderGuest::class)
            ->wherePivot('status', ReminderStatus::PENDING)
            ->withPivot('user_id', 'reminder_id', 'status', 'created_at');
    }

    /**
     * The reminders in which the user is a guest.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guestReminders()
    {
        return $this->belongsToMany(Reminder::class, 'reminder_guests')
            ->wherePivot('status', ReminderStatus::ACCEPTED)
            ->withPivot('user_id', 'reminder_id', 'status')
            ->with('guests');
    }
}
