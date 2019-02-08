<?php

namespace Tests\Unit;

use App\Reminder;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_reminder_has_only_one_owner()
    {
        $reminder = factory(Reminder::class)->create();

        $this->assertInstanceOf(User::class, $reminder->owner);
    }

    /** @test */
    public function a_reminder_has_many_guests()
    {
        $reminder = factory(Reminder::class)->create();

        $this->assertInstanceOf(Collection::class, $reminder->guests);
    }
}
