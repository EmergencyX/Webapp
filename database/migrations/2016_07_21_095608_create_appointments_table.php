<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_version_id')->unsigned();
            $table->integer('profile_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('voicechat')->nullable();
            $table->string('description')->nullable();
            $table->boolean('visible')->default(false);
            $table->dateTime('date_at');	
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointments');
    }
}
