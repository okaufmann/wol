<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUseBroadcastFieldToComputersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('computers', function(Blueprint $table)
		{
			$table->tinyInteger('use_broadcast')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('computers', function(Blueprint $table)
		{
			$table->dropColumn('use_broadcast');
		});
	}

}
