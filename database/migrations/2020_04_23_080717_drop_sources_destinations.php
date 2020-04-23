<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSourcesDestinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sources');
        Schema::dropIfExists('destinations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->bigIncrements('source_id');
            $table->string('sourceName');
        });

        Schema::create('destinations', function (Blueprint $table) {
            $table->bigIncrements('destination_id');
            $table->string('destinationName');
        });
    }
}
