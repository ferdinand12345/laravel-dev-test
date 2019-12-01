<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmContactTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'TM_CONTACT', function ( Blueprint $table ) {
			$table->bigIncrements( 'ID' );
			$table->string( 'AVATAR', 100 )->nullable();
			$table->string( 'FIRSTNAME', 64 );
			$table->string( 'LASTNAME', 64 );
			$table->string( 'EMAIL', 255 )->unique();
			$table->string( 'ADDRESS', 255 )->nullable();
			$table->unsignedMediumInteger( 'COUNTRY_ID' );
			$table->string( 'CITY_NAME', 64 );
			$table->string( 'ZIP_CODE', 64 );
			$table->string( 'PHONE_NUMBER', 15 )->unique();
			$table->longText( 'NOTE' )->nullable();
			$table->unique( [
				'EMAIL',
				'PHONE_NUMBER'
			], 'UNIQUE_TM_CONTACT' );
			$table->index( [
				'LASTNAME',
				'FIRSTNAME',
				'COUNTRY_ID',
				'CITY_NAME',
				'ZIP_CODE'
			], 'INDEX_TM_CONTACT' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('TM_CONTACT');
	}
}
