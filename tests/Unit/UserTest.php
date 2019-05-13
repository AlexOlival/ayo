<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
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
    public function a_user_may_search_for_other_users_but_cannot_find_itself()
    {
        $alex = factory(User::class)->create(['username' => 'alex']);

        $this->signIn($alex);

        $john = factory(User::class)->create(['username' => 'john']);
        $jack = factory(User::class)->create(['username' => 'jack']);

        $this->get("/search-users?q=''")
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $response = $this->get('/search-users?q=j')
            ->assertStatus(Response::HTTP_OK);

        $results = $response->original;

        $this->assertCount(2, $results);
        $this->assertTrue($results->contains($john));
        $this->assertTrue($results->contains($jack));

        $this->get('/search-users?q=a')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
