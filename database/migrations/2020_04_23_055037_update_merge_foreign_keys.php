<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMergeForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statemerge', function (Blueprint $table) {
            $table->dropForeign("statemerge_sourceid_foreign");
            $table->dropForeign("statemerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
        });

        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->dropForeign("pendingstatemerge_sourceid_foreign");
            $table->dropForeign("pendingstatemerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
        });

        Schema::table('countymerge', function (Blueprint $table) {
            $table->dropForeign("countymerge_sourceid_foreign");
            $table->dropForeign("countymerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
        });

        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->dropForeign("pendingcountymerge_sourceid_foreign");
            $table->dropForeign("pendingcountymerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
        });

        Schema::table('citymerge', function (Blueprint $table) {
            $table->dropForeign("citymerge_sourceid_foreign");
            $table->dropForeign("citymerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
        });

        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->dropForeign("pendingcitymerge_sourceid_foreign");
            $table->dropForeign("pendingcitymerge_destinationid_foreign");
            $table->foreign('sourceID')->references('node_id')->on('reusenodes');
            $table->foreign('destinationID')->references('node_id')->on('reusenodes');
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
    }
}
