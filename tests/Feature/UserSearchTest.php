<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_search_for_users()
    {
        $this->get('/search-users?q=a')->assertRedirect('/');
    }

    /** @test */
    public function an_authenticated_user_may_search_for_other_users()
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
