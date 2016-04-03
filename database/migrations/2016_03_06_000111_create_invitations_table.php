<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('from_user_id')->unsigned();
            $table->integer('for_user_id')->unsigned();
            $table->integer('invitation_target_id')->unsigned();
            $table->tinyInteger('invitation_type')->unsigned();
            $table->tinyInteger('invitation_state')->unsigned();
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
        Schema::drop('invitations');
    }
}
