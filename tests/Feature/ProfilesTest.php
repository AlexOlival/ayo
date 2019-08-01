<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_their_profile()
    {
        $this->signIn();

        $this->get('/profile')->assertViewIs('profile.show');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_thier_profile()
    {
        $this->get('/profile')->assertRedirect('/');
    }

    /** @test */
    public function users_can_see_their_profile_information()
    {
        $attr = [
            'username' => 'johndoe',
            'email' => 'johndoe@email.com',
            'password' => 'password'
        ];

        $user = factory(User::class)->create($attr);

        $this->signIn($user);

        $this->get('/profile')->assertSeeText($user->username)
            ->assertSeeText($user->email);
    }
}
