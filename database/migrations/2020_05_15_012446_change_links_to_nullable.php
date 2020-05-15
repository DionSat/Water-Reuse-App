<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLinksToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statemerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
        });
        Schema::table('countymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
        });
        Schema::table('citymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
        });
        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
        });
        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
        });
        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable()->change();
            $table->unsignedBigInteger('permit')->nullable()->change();
            $table->unsignedBigInteger('incentives')->nullable()->change();
            $table->unsignedBigInteger('moreInfo')->nullable()->change();
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
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
        Schema::table('countymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
        Schema::table('citymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->unsignedBigInteger('codes')->nullable(false)->change();
            $table->unsignedBigInteger('permit')->nullable(false)->change();
            $table->unsignedBigInteger('incentives')->nullable(false)->change();
            $table->unsignedBigInteger('moreInfo')->nullable(false)->change();
        });
    }
}
