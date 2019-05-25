<?php

namespace Tests\Feature;

use App\User;
use App\Reminder;
use Tests\TestCase;
use App\Constants\ReminderStatus;
use Illuminate\Foundation\Testing\WithFaker;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function only_authenticated_users_can_invite_users()
    {
        $attributes = factory(Reminder::class)->raw();

        $this->post('/reminders', $attributes)->assertRedirect('/');
    }

    /** @test */
    public function a_user_can_invite_another_user_to_a_reminder_he_is_creating()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $guest = factory(User::class)->create();

        $owner = auth()->user();

        $attributes = [
            'title' => 'Title',
            'description' => $this->faker->word,
            'notification_date' => now()->addDay()->toDateString(),
            'guests' => [$guest->id],
        ];

        $this->post('/reminders', $attributes)->assertStatus(Response::HTTP_CREATED);

        $reminder = $owner->fresh()->reminders->first();

        $this->assertDatabaseHas('reminders', ['title' => 'Title']);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
            ]
        );

        $this->assertCount(1, $reminder->invited);

        $this->assertCount(1, $guest->fresh()->invites);
    }

    /** @test */
    public function a_user_can_invite_another_user_to_a_reminder_he_has_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $guest = factory(User::class)->create();

        $attributes = [
            'title' => 'Title',
            'description' => $this->faker->word,
            'notification_date' => now()->addDay()->toDateString(),
        ];

        $reminder = auth()->user()->reminders()->create($attributes);

        $this->patch("/reminders/$reminder->id", ['guests' => [2]])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
            ]
        );

        $this->assertCount(1, $reminder->invited);

        $this->assertCount(1, $guest->fresh()->invites);
    }

    /** @test */
    public function a_user_can_not_invite_another_user_to_a_reminder_twice()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $guest = factory(User::class)->create();

        $attributes = [
            'title' => 'Title',
            'description' => $this->faker->word,
            'notification_date' => now()->addDay()->toDateString(),
        ];

        $reminder = auth()->user()->reminders()->create($attributes);

        $this->patch("/reminders/$reminder->id", ['guests' => [2]])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
            ]
        );

        $this->assertCount(1, $reminder->invited);

        $this->assertCount(1, $guest->fresh()->invites);

        $this->patch("/reminders/$reminder->id", ['guests' => [2]])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
            ]
        );

        $this->assertCount(1, $reminder->invited);

        $this->assertCount(1, $guest->fresh()->invites);
    }

    /** @test */
    public function an_invite_is_marked_as_pending_when_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $guest = factory(User::class)->create();

        $attributes = [
            'title' => 'Title',
            'description' => $this->faker->word,
            'notification_date' => now()->addDay()->toDateString(),
        ];

        $reminder = auth()->user()->reminders()->create($attributes);

        $this->patch("/reminders/$reminder->id", ['guests' => [2]])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );

        $this->assertCount(1, $reminder->invited);

        $this->assertCount(1, $guest->fresh()->invites);
    }
}
