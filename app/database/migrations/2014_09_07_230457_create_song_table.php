<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('song', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('artist');
			$table->text('title');
			$table->integer('status');
			$table->datetime('created');
			$table->datetime('last_update');
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
		Schema::drop('song');
	}

}
