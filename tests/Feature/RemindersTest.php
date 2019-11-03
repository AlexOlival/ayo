<?php

namespace Tests\Feature;

use App\Reminder;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemindersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function only_authenticated_users_can_create_reminders()
    {
        $attributes = factory(Reminder::class)->raw();

        $this->post('/reminders', $attributes)->assertRedirect('/');
    }

    /** @test */
    public function a_user_can_create_a_reminder()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $attributes = [
            'title' => 'Title',
            'description' => $this->faker->word,
            'notification_date' => now()->addDay()->toDateString(),
        ];

        $this->post('/reminders', $attributes)->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('reminders', ['title' => 'Title']);
    }

    /** @test */
    public function a_reminder_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Reminder::class)->raw(['title' => '']);

        $this->post('/reminders', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_reminder_requires_a_notification_date()
    {
        $this->signIn();

        $attributes = factory(Reminder::class)->raw(['notification_date' => '']);

        $this->post('/reminders', $attributes)->assertSessionHasErrors('notification_date');
    }

    /** @test */
    public function a_reminder_requires_a_notification_date_after_the_current_date()
    {
        $this->signIn();

        $attributes = factory(Reminder::class)->raw(['notification_date' => now()->subDay()]);

        $this->post('/reminders', $attributes)->assertSessionHasErrors('notification_date');
    }

    /** @test */
    public function a_user_can_update_a_reminder()
    {
        $this->signIn();

        $attributes = [
            'title' => 'Reminder A',
            'description' => $this->faker->text(50),
            'notification_date' => now()->addDay()->toDateString(),
        ];

        $reminder = auth()->user()->reminders()->create($attributes);

        $this->patch("/reminders/$reminder->id", ['title' => 'Reminder B'])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('reminders', ['title' => 'Reminder B']);
    }

    /** @test */
    public function a_user_cannot_update_the_reminders_of_others()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create();

        $this->patch("/reminders/$reminder->id", ['title' => ''])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_user_can_see_upcoming_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addDay(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $result->assertViewHas('upcomingReminders');
        $result->assertViewHas('upcomingReminderCount');

        $this->assertTrue($result->viewData('upcomingReminders')->contains($reminder));
        $this->assertEquals(1, $result->viewData('upcomingReminderCount'));
    }

    /** @test */
    public function a_user_can_see_ten_days_after_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addDays(7),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $result->assertViewHas('tenDaysAfterReminders');
        $result->assertViewHas('tenDaysAfterReminderCount');

        $this->assertTrue($result->viewData('tenDaysAfterReminders')->contains($reminder));
        $this->assertEquals(1, $result->viewData('tenDaysAfterReminderCount'));
    }

    /** @test */
    public function a_user_can_see_much_later_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addMonths(3),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $result->assertViewHas('laterReminders');
        $result->assertViewHas('laterReminderCount');

        $this->assertTrue($result->viewData('laterReminders')->contains($reminder));
        $this->assertEquals(1, $result->viewData('laterReminderCount'));
    }

    /** @test */
    public function a_user_can_not_see_an_upcoming_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addDay(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $this->assertFalse($result->viewData('tenDaysAfterReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('tenDaysAfterReminderCount'));

        $this->assertFalse($result->viewData('laterReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('laterReminderCount'));
    }

    /** @test */
    public function a_user_can_not_see_a_ten_day_after_reminder_off_its_period()
    {
        Carbon::setTestNow(now()->startOfMonth());

        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $this->assertFalse($result->viewData('upcomingReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('upcomingReminderCount'));

        $this->assertFalse($result->viewData('laterReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('laterReminderCount'));
    }

    /** @test */
    public function a_user_can_not_see_a_much_later_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addMonths(3),
            'owner_id' => auth()->user()->id]);

        $result = $this->get('home')
            ->assertStatus(Response::HTTP_OK);

        $this->assertFalse($result->viewData('upcomingReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('upcomingReminderCount'));

        $this->assertFalse($result->viewData('tenDaysAfterReminders')->contains($reminder));
        $this->assertEquals(0, $result->viewData('tenDaysAfterReminderCount'));
    }

    /** @test */
    public function a_user_can_not_see_their_paginated_reminders_if_there_are_less_than_four()
    {
        $this->signIn();

        factory(Reminder::class)->create(
            [
                'notification_date' => now()->addMonths(3),
                'owner_id' => auth()->user()->id
            ]
        );

        $this->get('expanded-reminders?period=later')
            ->assertRedirect('home');
    }

    /** @test */
    public function a_user_can_see_their_paginated_reminders_if_there_are_more_than_four()
    {
        $this->signIn();

        factory(Reminder::class, 10)->create(
            [
                'notification_date' => now()->addMonths(3),
                'owner_id' => auth()->user()->id
            ]
        );

        $this->get('expanded-reminders?period=later')
            ->assertViewIs('reminders.paginated')
            ->assertViewHas('reminders');
    }

    /** @test */
    public function reminders_of_users_are_deleted_if_they_delete_their_account()
    {
        $this->signIn();

        $user = auth()->user();

        $reminders = factory(Reminder::class, 5)->create(['owner_id' => $user->id]);

        $reminders->each(function ($reminder) {
            $this->assertDatabaseHas('reminders', ['id' => $reminder->id]);
        });

        $this->delete("/users/{$user->id}");

        $reminders->each(function ($reminder) {
            $this->assertDatabaseMissing('reminders', ['id' => $reminder->id]);
        });
    }
}
