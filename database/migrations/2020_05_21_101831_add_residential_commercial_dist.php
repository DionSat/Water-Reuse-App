<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResidentialCommercialDist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statemerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
        });

        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
        });

        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
        });

        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->enum('location_type', ['residential', 'commercial'])->default('residential');
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
            $table->dropColumn('location_type');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });

        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });

        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });

        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->dropColumn('location_type');
        });
    }
}
