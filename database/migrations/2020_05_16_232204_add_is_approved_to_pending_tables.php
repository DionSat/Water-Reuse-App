<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsApprovedToPendingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('states', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);
        });

        Schema::table('counties', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });

        Schema::table('counties', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }
}

