<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IntroduceJsonType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('releases', function (Blueprint $table) {
            $table->dropColumn('extra');
            $table->boolean('visible')->after('beta')->default(false);
            $table->json('meta')->after('beta')->nullable();
            $table->integer('game_version_id')->after('project_repository_id')->unsigned();
        });

        Schema::table('project_repositories', function (Blueprint $table) {
            $table->dropColumn('extra');
            $table->boolean('visible')->after('name')->default(false);
            $table->json('meta')->after('name')->nullable();
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('extra');
            $table->boolean('visible')->after('description')->default(false);
            $table->json('meta')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
