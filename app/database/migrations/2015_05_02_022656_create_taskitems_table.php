<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskitems', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('item_categorycode')->nullable();
            $table->string('itemname')->nullable();
            $table->string('itemcode')->nullable();
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
        Schema::drop('taskitems');
    }

}
