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
			$table->enum('status', array('aangevraagd', 'uitgestemd', 'onvindbaar', 'besteld'))->default('aangevraagd');
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
			if (Schema::hasColumn('song', 'status'))
				$table->dropColumn('status');
			if (Schema::hasColumn('song', 'modifier'))
				$table->dropColumn('modifier');

		});
	}

}
