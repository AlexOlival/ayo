<?php

namespace Tests\Unit;

use App\User;
use App\Reminder;
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
}
