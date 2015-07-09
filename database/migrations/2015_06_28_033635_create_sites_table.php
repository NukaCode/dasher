<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->index();
            $table->string('name', 255);
            $table->string('path', 255);
            $table->smallInteger('port');
            $table->string('uuid', 36);
            $table->string('status', 255)->default('Adding site to database');
            $table->boolean('homesteadFlag')->default(0);
            $table->boolean('readyFlag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sites');
    }
}
