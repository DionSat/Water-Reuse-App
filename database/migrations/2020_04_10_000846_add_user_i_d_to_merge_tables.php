<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIDToMergeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statemerge', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default('1');;
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default('1');;
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default('1');;
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statemerge', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
