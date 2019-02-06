<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function an_email_is_sent_to_the_user_after_registration()
    {
        Notification::fake();

        $this->post('/register', [
            'username' => $this->faker->userName,
            'name' => 'Test',
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $user = User::where('name', 'Test')->first();

        Notification::assertSentTo(
            $user, VerifyEmail::class
        );
    }
}
