<?php

namespace Tests\Unit;

use App\User;
use App\Reminder;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $reminder = factory(Reminder::class)->create();

        $this->assertInstanceOf(User::class, $reminder->owner);
    }

    /** @test */
    public function it_has_a_path()
    {
        $reminder = factory(Reminder::class)->create();

        $this->assertEquals('/reminders/1', $reminder->path());
    }

    /** @test */
    public function reminder_returns_upcoming()
    {
        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addDay()])->first();
        $results = Reminder::upcoming()->get();

        $this->assertTrue($results->contains($reminder));
    }

    /** @test */
    public function reminder_returns_next_week()
    {
        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(1)])->first();
        $results = Reminder::nextWeek()->get();

        $this->assertTrue($results->contains($reminder));
    }

    /** @test */
    public function reminder_returns_later_this_month()
    {
        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(2)])->first();
        $results = Reminder::month()->get();

        $this->assertTrue($results->contains($reminder));
    }

    /** @test */
    public function reminder_returns_much_later()
    {
        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addMonth(2)])->first();
        $results = Reminder::muchLater()->get();

        $this->assertTrue($results->contains($reminder));
    }
}
