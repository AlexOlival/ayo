<?php

use App\Reminder;
use App\User;
use Illuminate\Database\Seeder;

class RemindersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reminder::class, 10)->create()->each(function ($reminder) {
            $reminder->guests()->attach(
                User::all()->random(2),
                ['status' => random_int(0, 2), 'created_at' => now(), 'updated_at' => now()]
            );
        });
    }
}
