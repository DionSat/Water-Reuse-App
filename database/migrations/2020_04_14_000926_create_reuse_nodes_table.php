<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReuseNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reusenodes', function (Blueprint $table) {
            $table->bigIncrements('node_id');
            $table->string('node_name');
            $table->string('is_source');
            $table->string('is_destination');
            $table->string('is_fixture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reusenodes');
    }
}
