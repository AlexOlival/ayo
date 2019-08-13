<?php

namespace Tests\Setup;

use App\Reminder;

class ReminderFactory
{
    /**
     * The number of guests for the reminder.
     *
     * @var int
     */
    protected $numberOfGuests = 0;

    /**
     * Set the number of guests for the reminder.
     *
     * @param  int $numberOfGuests
     * @return $this
     */
    public function withGuest($numberOfGuests = 1)
    {
        $this->numberOfGuests = $numberOfGuests;

        return $this;
    }

    /**
     * Set the owner of the reminder.
     *
     * @param  App\User $owner
     * @return $this
     */
    public function withOwner($owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Arrange the world.
     *
     * @return Reminder
     */
    public function create()
    {
        $reminder = factory(Reminder::class)->create([
            'owner_id' => $this->owner->id,
        ]);

        return $reminder;
    }
}
