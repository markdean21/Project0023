<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('firstName')->nullable();
            $table->string('midName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('fullName')->nullable();
            $table->string('companyName')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->default('PHILIPPINES');
            $table->string('gender')->nullable();
            $table->string('profilePic')->nullable();
            $table->string('confirmationCode')->nullable();
            $table->string('status')->nullable();
            $table->string('workTime')->nullable();
            $table->string('businessPermit')->nullable();
            $table->string('businessDescription')->nullable();
            $table->string('businessNature')->nullable();
            $table->string('tin')->nullable();
            $table->string('businessNum')->nullable();
            $table->string('registrationNum')->nullable();
            $table->integer('operationYears')->nullable();
            // FOR TASKMINATORS
            $table->string('educationalBackground')->nullable();
            $table->string('servicesOffered')->nullable();
            $table->string('skills')->nullable();
            $table->integer('yearsOfExperience')->nullable();
            $table->integer('maxRate')->nullable();
            $table->integer('minRate')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();

            // FOR CLIENTS
            $table->string('accountType')->nullable();
            $table->float('points')->nullable();
//            THERE ARE 3 TYPES OF ACCOUNTS FOR CLIENTS :
//            Basic Account : BASIC
//            Premium Account : PREMIUM
//            Ultimate Account : ULTIMATE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
