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

    /** @test */
    public function invites_of_users_are_deleted_if_a_guest_deletes_their_account()
    {
        $this->signIn();

        $guest = auth()->user();

        $owner = factory(User::class)->create();

        $reminder = factory(Reminder::class)->create(['owner_id' => $owner->id]);

        $reminder->inviteUsers([$guest->id]);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );

        $this->delete("/users/{$guest->id}");

        $this->assertDatabaseMissing(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );
    }

    /** @test */
    public function invites_of_users_are_deleted_if_an_owner_deletes_their_account()
    {
        $this->signIn();

        $owner = auth()->user();

        $guest = factory(User::class)->create();

        $reminder = factory(Reminder::class)->create(['owner_id' => $owner->id]);

        $reminder->inviteUsers([$guest->id]);

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );

        $this->delete("/users/{$owner->id}");

        $this->assertDatabaseMissing(
            'reminder_guests',
            [
                'reminder_id' => $reminder->id,
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );
    }

    /** @test */
    public function a_user_can_not_see_their_paginated_invites_if_there_are_less_than_four()
    {
        $this->signIn();

        $owner = factory(User::class)->create();

        $guest = auth()->user();

        $reminder = factory(Reminder::class)->create(['owner_id' => $owner->id]);

        $reminder->inviteUsers([$guest->id]);

        $this->get('expanded-invites')
            ->assertRedirect('home');
    }

    /** @test */
    public function a_user_can_see_their_paginated_reminders_if_there_are_more_than_four()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $owner = factory(User::class)->create();

        $guest = auth()->user();

        $reminders = factory(Reminder::class, 10)->create(['owner_id' => $owner->id]);

        $reminders->each(function($reminder) use ($guest) {
            $reminder->inviteUsers([$guest->id]);
        });

        $this->get('expanded-invites')
            ->assertViewIs('invites.paginated')
            ->assertViewHas('invites');
    }

    /** @test */
    public function an_invite_can_be_accepted()
    {
        $guest = factory(User::class)->create(['username' => 'guest']);

        $reminder = factory(Reminder::class)->create();
        $reminder->inviteUsers([$guest->id]);

        $reminder = $reminder->fresh();

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );

        $this->signIn($guest);

        $this->patch("/accept-invite/{$reminder->id}");

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'user_id' => $guest->id,
                'status' => ReminderStatus::ACCEPTED,
            ]
        );
    }

    /** @test */
    public function an_invite_can_be_refused()
    {
        $guest = factory(User::class)->create(['username' => 'guest']);

        $reminder = factory(Reminder::class)->create();
        $reminder->inviteUsers([$guest->id]);

        $reminder = $reminder->fresh();

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'user_id' => $guest->id,
                'status' => ReminderStatus::PENDING,
            ]
        );

        $this->signIn($guest);

        $this->patch("/refuse-invite/{$reminder->id}");

        $this->assertDatabaseHas(
            'reminder_guests',
            [
                'user_id' => $guest->id,
                'status' => ReminderStatus::REFUSED,
            ]
        );
    }
}
