<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMediumToSongTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('song', function(Blueprint $table)
		{
			$table->enum('medium', array('cd', 'mp3'))->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('song', function(Blueprint $table)
		{
			$table->dropColumn('medium');
		});
	}

}
