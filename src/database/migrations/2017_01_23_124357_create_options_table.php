<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larapoll_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('poll_id');
            $table->integer('votes')->default(0);
            $table->timestamps();

            $table->foreign('poll_id')->references('id')->on('larapoll_polls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('larapoll_options');
    }
}
