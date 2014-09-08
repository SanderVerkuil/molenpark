<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Songs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('artist');
			$table->string('title');
			$table->string('requestee');
			$table->integer('status');
			$table->string('videokey');
			$table->string('genre');
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
		Schema::drop('Songs');
	}

}
