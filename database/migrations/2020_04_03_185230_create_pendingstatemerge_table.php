<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingStateMergeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendingstatemerge', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('stateID');
            $table->foreign('stateID')->references('state_id')->on('states');

            $table->unsignedBigInteger('sourceID');
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');

            $table->unsignedBigInteger('destinationID');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');

            $table->unsignedBigInteger('allowedID');
            $table->foreign('allowedID')->references('allowed_id')->on('allowed');

            $table->unsignedBigInteger('codes')->nullable();
            $table->foreign('codes')->references('link_id')->on('links');

            $table->unsignedBigInteger('permit')->nullable();
            $table->foreign('permit')->references('link_id')->on('links');

            $table->unsignedBigInteger('incentives')->nullable();
            $table->foreign('incentives')->references('link_id')->on('links');

            $table->unsignedBigInteger('moreInfo')->nullable();
            $table->foreign('moreInfo')->references('link_id')->on('links');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendingstatemerge');
    }
}
