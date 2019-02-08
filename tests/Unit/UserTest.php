<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_reminders()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->reminders);
    }

    /** @test */
    public function a_user_can_have_guest_reminders()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->guestReminders);
    }
}
