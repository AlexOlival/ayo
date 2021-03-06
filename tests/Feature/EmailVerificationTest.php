<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function an_email_is_sent_to_the_user_after_registration()
    {
        Notification::fake();

        $this->post('/register', [
            'username' => 'testuser123',
            'email' => $this->faker->email,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $user = User::whereUsername('testuser123')->first();

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }
}
