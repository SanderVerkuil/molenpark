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
			$table->string('title');
			$table->string('artist');
			$table->string('requester');
			$table->string('genre')->nullable();
			$table->string('youtube_key')->nullable();
			$table->string('link')->nullable();
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
