<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('statemerge', function (Blueprint $table) {
            $table->string('comments')->nullable();
        });

        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->string('comments')->nullable();
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->string('comments')->nullable();
        });

        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->string('comments')->nullable();
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->string('comments')->nullable();
        });

        Schema::table('pendingcitymerge', function (Blueprint $table) {
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
        //
        Schema::table('statemerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });

        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });

        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });

        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->dropColumn('comments');
        });
    }
}
