<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReminderGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminder_guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reminder_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminder_guests');
    }
}
