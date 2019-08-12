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

    /** @test */
    public function a_user_may_search_for_other_users_but_may_not_find_itself()
    {
        $alex = factory(User::class)->create(['username' => 'alex']);
        $this->signIn($alex);

        factory(User::class)->create(['username' => 'john']);
        factory(User::class)->create(['username' => 'jack']);

        $results = $alex->search('x')->get();
        $this->assertEmpty($results);

        $results = $alex->search('j')->get();
        $this->assertCount(2, $results);
        $this->assertFalse($results->contains($alex));

        $results = $alex->search('a')->get();
        $this->assertEmpty($results);
    }

    /** @test */
    public function users_can_delete_their_account()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $this->assertDatabaseHas('users', ['email' => $user->email]);
        $this->assertTrue(auth()->check());

        $this->delete("/users/{$user->id}")
            ->assertRedirect(route('welcome'));

        $this->assertDatabaseMissing('users', ['email' => $user->email]);
        $this->assertFalse(auth()->check());
    }
}
