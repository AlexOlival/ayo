<?php

namespace Tests\Setup;

use App\Reminder;
use App\User;

class UserFactory
{
    /**
     * The number of reminders for the user.
     *
     * @var int
     */
    protected $numberOfReminders = 0;

    /**
     * Set the number of reminder for the user.
     *
     * @param  App\User $numberOfReminders
     * @return $this
     */
    public function withReminders($numberOfReminders = 1)
    {
        $this->numberOfReminders = $numberOfReminders;

        return $this;
    }

    /**
     * Arrange the world.
     *
     * @return User
     */
    public function create()
    {
        $user = factory(User::class)->create();
        factory(Reminder::class, $this->numberOfReminders)->create([
            'owner_id' => $user,
        ]);

        return $user;
    }
}
