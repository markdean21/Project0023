<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskminatorHasSkills extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taskminator_has_skills', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id')->nullable();
			$table->string('taskitem_code')->nullable();
			$table->string('taskcategory_code')->nullable();
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
		Schema::drop('taskminator_has_skills');
	}

}
