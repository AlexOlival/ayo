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
    public function a_user_can_create_a_reminder()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'notification_date' => Carbon::now()->addDay()->toDateString(),
            'file_attached' => '\temp',
        ];

        $this->post('/reminders', $attributes)->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('reminders', $attributes);
    }

    /** @test */
    public function a_reminder_requires_a_title()
    {
        $attributes = factory(Reminder::class)->raw(['title' => '']);

        $this->post('/reminders', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_reminder_requires_a_notification_date()
    {
        $attributes = factory(Reminder::class)->raw(['notification_date' => '']);

        $this->post('/reminders', $attributes)->assertSessionHasErrors('notification_date');
    }
}
