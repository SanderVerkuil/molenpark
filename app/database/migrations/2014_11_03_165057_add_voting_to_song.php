<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVotingToSong extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('song', function(Blueprint $table)
		{
			$table->integer('supporters')->default(0);
			$table->integer('opposers')->default(0);
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
			if (Schema::hasColumn('song', 'supporters'))
				$table->dropCOlumn('song', 'supporters');
			if (Schema::hasColumn('song', 'opposers'))
				$table->dropCOlumn('song', 'opposers');
		});
	}

}