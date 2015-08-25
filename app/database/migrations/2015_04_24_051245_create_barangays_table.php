<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangays', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('regcode')->nullable();
            $table->string('provcode')->nullable();
            $table->string('citycode')->nullable();
            $table->string('bgycode')->nullable();
            $table->string('bgyname')->nullable();
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
        Schema::drop('barangays');
    }

}
