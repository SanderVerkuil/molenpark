<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('password')->nullable();
			$table->string('email')->nullable();
			$table->string('activation')->nullable();
			$table->date('activation_due')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			if (Schema::hasColumn('users', 'password'))
				Schema::dropColumn('users', 'password');
			if (Schema::hasColumn('users', 'email'))
				Schema::dropColumn('users', 'email');
			if (Schema::hasColumn('users', 'activation'))
				Schema::dropColumn('users', 'activation');
			if (Schema::hasColumn('users', 'activation_due'))
				Schema::dropColumn('users', 'activation_due');
		});
	}

}
