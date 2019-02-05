<?php

namespace Tests\Feature;

use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\User;

class EmailVerificationTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function email_is_sent_after_user_registers()
    {
        Notification::fake();

        $password_testing = 'secret';
        $name_testing = $this->faker->name;

        $this->post('/register', [
            'username'             => $this->faker->userName,
            'name'                 => $name_testing,
            'email'                => $this->faker->email,
            'password'             => $password_testing,
            'password_confirmation' => $password_testing
        ]);

        $user = User::where('name', $name_testing)->first();

        Notification::assertSentTo(
            $user, VerifyEmail::class
        );
    }
}