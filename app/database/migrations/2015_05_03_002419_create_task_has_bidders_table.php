<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskHasBiddersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_has_bidders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('task_id')->nullable();
            $table->string('task_hiringType')->nullable();
            $table->string('taskminator_id')->nullable();
            $table->string('proposedRate')->nullable();
            $table->string('proposedDuration')->nullable();
            $table->string('message')->nullable();
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
        Schema::drop('task_has_bidders');
    }

}
