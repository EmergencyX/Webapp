<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleaseUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('release_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('progress')->unsigned()->default(0);
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
        Schema::drop('release_user');
    }
}
