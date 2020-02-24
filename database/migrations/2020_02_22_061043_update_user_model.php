<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('streetAddress');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipCode');
            $table->string('jobTitle')->nullable();
            $table->string('company')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('contactList')->nullable();
            $table->biginteger('phoneNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
