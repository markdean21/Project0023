<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskminatorHasOfferTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskminator_has_offer', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('task_id')->nullable();
            $table->string('client_id')->nullable();
            $table->string('taskminator_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('taskminator_has_offer');
    }

}
