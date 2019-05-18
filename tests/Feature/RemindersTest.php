<?php

namespace Tests\Feature;

use App\Reminder;
use Tests\TestCase;
use App\Constants\ReminderPeriod;
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

        $result = $this->get("/reminders?period=".ReminderPeriod::UPCOMING)
            ->assertStatus(Response::HTTP_OK);

        $this->assertSame($reminder->id, $result->original->first()->id);
    }

    /** @test */
    public function a_user_can_see_next_week_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::NEXT_WEEK)
            ->assertStatus(Response::HTTP_OK);

        $this->assertSame($reminder->id, $result->original->first()->id);
    }

    /** @test */
    public function a_user_can_see_this_month_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(2),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::MONTH)
            ->assertStatus(Response::HTTP_OK);

        $this->assertSame($reminder->id, $result->original->first()->id);
    }

    /** @test */
    public function a_user_can_see_much_later_reminders()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addMonth(3),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::LATER)
            ->assertStatus(Response::HTTP_OK);

        $this->assertSame($reminder->id, $result->original->first()->id);
    }

    /** @test */
    public function a_user_can_not_see_an_upcoming_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addDay(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::NEXT_WEEK)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::MONTH)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::LATER)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);
    }

    /** @test */
    public function a_user_can_not_see_a_next_week_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::UPCOMING)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::MONTH)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::LATER)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);
    }

    /** @test */
    public function a_user_can_not_see_a_month_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addWeek(2),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::UPCOMING)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::NEXT_WEEK)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::LATER)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);
    }

    /** @test */
    public function a_user_can_not_see_a_much_later_reminder_off_its_period()
    {
        $this->signIn();

        $reminder = factory(Reminder::class)->create(['notification_date' => now()->addMonth(3),
            'owner_id' => auth()->user()->id]);

        $result = $this->get("/reminders?period=".ReminderPeriod::UPCOMING)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::NEXT_WEEK)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);

        $result = $this->get("/reminders?period=".ReminderPeriod::MONTH)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotContains($reminder, $result->original);
    }
}
