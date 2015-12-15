<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStatusToSongTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('song', function(Blueprint $table)
		{
			$table->enum('status', Config::get('enum.songstatus'))->default('aangevraagd');
			$table->string('modifier')->nullable();
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
			$table->dropColumn(['status','modifier']);

		});
	}

}
