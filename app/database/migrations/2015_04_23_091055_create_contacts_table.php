<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('ctype')->nullable();
            $table->string('content')->nullable();
            $table->string('priority')->default('0');
            $table->timestamps();
//            Contact types are :
//            facebook
//            linkedin
//            skype
//            email
//            mobileNum
//            businessNum
//            website
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }

}
