<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchemaChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add show results config column
        Schema::table('larapoll_polls', function ($table) {
            $table->boolean('canVoterSeeResult')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('larapoll_polls', function (Blueprint $table) {
            $table->dropColumn('canVoterSeeResult');
        });
    }
}
