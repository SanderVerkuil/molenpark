<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAlbuminfoToSongTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('song', function(Blueprint $table)
		{
			$table->string('album')->nullable();
			$table->integer('track')->default(-1);
			$table->string('remarks')->nullable();
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
			$table->dropColumn(['album','track','remarks']);
		});
	}

}
