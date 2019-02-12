<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Reminder::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'notification_date' => now()->addDay(),
        'owner_id' => function () {
            return factory(User::class);
        }
    ];
});