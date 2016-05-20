<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act', function (Blueprint $table) {
            $table->increments('act_id');
            $table->string('name', 64);
            $table->integer('creator_uid');
            $table->integer('people1_uid')->default(-1);
            $table->integer('people2_uid')->default(-1);
            $table->integer('people3_uid')->default(-1);
            $table->string('from');
            $table->string('to');
            $table->integer('expectedNumber');
            $table->integer('state'); // 0 for active, 1 for completed
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
        Schema::drop('act');
    }
}
