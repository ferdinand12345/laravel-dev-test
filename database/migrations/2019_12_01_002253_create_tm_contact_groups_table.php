<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmContactGroupsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'TM_CONTACT_GROUPS', function ( Blueprint $table ) {
			$table->bigIncrements( 'ID' );
			$table->string( 'NAME', 255 );
			$table->unsignedBigInteger( 'CONTACT_ID' );
			$table->index( [
				'CONTACT_ID',
				'NAME',
			], 'INDEX_TM_CONTACT_GROUP' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'TM_CONTACT_GROUPS' );
	}
}
