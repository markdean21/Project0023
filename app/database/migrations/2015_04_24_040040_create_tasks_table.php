<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('salary')->nullable();
            $table->string('status')->nullable();
            $table->string('taskCategory')->nullable();
            $table->string('taskType')->nullable();
            $table->string('workTime')->nullable();
            $table->string('hiringType')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('modeOfPayment')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('completed_by')->nullable();
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
        Schema::drop('tasks');
    }

}
