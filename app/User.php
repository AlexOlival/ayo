<?php

namespace App;

use App\Constants\ReminderPeriod;
use App\Constants\ReminderStatus;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\UnknownReminderPeriodException;
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
        'username', 'email', 'password', 'avatar_path',
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
     * Get the user's avatar path
     *
     * @param $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? "storage/$avatar" : '/storage/avatars/default.svg');
    }

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
            ->select('id', 'username', 'avatar_path')
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
        return $this->hasMany(Reminder::class, 'owner_id')
            ->with('guests')
            ->with('owner');
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
            ->withPivot('user_id', 'reminder_id', 'status', 'created_at')
            ->with('owner')
            ->withTimestamps();
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
            ->with('guests', 'owner');
    }

    /**
     * Get all owned and guest reminders of a given period
     *
     * @param string $period
     * @return Collection
     * @throws UnknownReminderPeriodException
     */
    public function getAllRemindersFromPeriod(string $period)
    {
        switch ($period) {
            case ReminderPeriod::UPCOMING:
                return $this->reminders()->upcoming()->get()
                    ->merge($this->guestReminders()->upcoming()->get());

            case ReminderPeriod::TEN_DAYS_AFTER:
                return $this->reminders()->tenDaysAfter()->get()
                    ->merge($this->guestReminders()->tenDaysAfter()->get());

            case ReminderPeriod::LATER:
                return $this->reminders()->muchLater()->get()
                    ->merge($this->guestReminders()->muchLater()->get());

            default:
                throw new UnknownReminderPeriodException("The reminder period $period does not exist");
        }
    }
}
