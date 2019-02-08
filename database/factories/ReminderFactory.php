<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Reminder::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'notification_date' => Carbon::now()->addDay()->toDateString(),
        'file_attached' => '\temp',
    ];
});
