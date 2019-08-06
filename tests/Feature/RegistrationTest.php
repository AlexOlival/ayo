<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function a_guest_may_not_register_with_an_email_that_is_already_registered()
    {
        $email = 'johndoe@example.com';
        factory(User::class)->create(['email' => $email]);

        $this->postJson('/register', $user = [
            'username' => $this->faker->userName,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('users', $user);
    }

    /** @test */
    public function a_guest_may_not_register_with_a_username_that_is_already_registered()
    {
        $username = 'johndoe';
        factory(User::class)->create(['username' => $username]);

        $this->postJson('/register', $user = [
            'username' => $username,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('users', $user);
    }

    /** @test */
    public function a_guest_may_register_with_an_unique_username_and_email()
    {
        factory(User::class)->create([
            'username' => $this->faker->userName,
            'email' => $this->faker->email
        ]);

        $this->postJson('/register', $user = [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', [
            'username' => $user['username']
        ]);
    }
}
