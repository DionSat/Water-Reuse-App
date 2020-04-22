<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendingstatemerge', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('pendingcitymerge', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('pendingcountymerge', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
    }
}
