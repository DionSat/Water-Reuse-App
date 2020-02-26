<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->bigIncrements('county_id');
            $table->string('countyName');

            $table->unsignedBigInteger('fk_state');

            $table->foreign('fk_state')->references('state_id')->on('states');

            // Set the foreign key to cascade deletions
            /*
            $table->foreign('fk_state')
                ->references('state_id')->on('states')
                ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}
