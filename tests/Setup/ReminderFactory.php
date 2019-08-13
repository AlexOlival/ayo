<?php

namespace Tests\Setup;

use App\Reminder;

class ReminderFactory
{
    /**
     * The number of guests for the family.
     *
     * @var int
     */
    protected $numberOfGuests = 0;

    /**
     * Set the number of members for the family.
     *
     * @param  int $count
     * @return $this
     */
    public function withGuest($count = 1)
    {
        $this->numberOfGuests = $count;

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
