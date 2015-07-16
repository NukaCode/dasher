<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortForwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port_forwards', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('starting_port')->unsigned();
            $table->smallInteger('destination_port')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('port_forwards');
    }
}
