<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('larapoll_polls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->integer('maxCheck')->default(1);
            $table->boolean('canVisitorsVote')->default(0);
            $table->timestamp('isClosed')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::drop('larapoll_polls');
    }
}
