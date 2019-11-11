<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class TaskTest extends TestCase {

	// public function testDBColumnCheck_TM_USER() {
	// 	$table_info_default_array = [
	// 		'ID',
	// 		'NAME',
	// 		'SURNAME',
	// 		'DOB',
	// 		'EMAIL',
	// 		'PASSWORD',
	// 		'PHONE_NUMBER',
	// 		'ADDRESS',
	// 		'COUNTRY',
	// 		'TRADING_ACCOUNT_NUMBER',
	// 		'BALANCE',
	// 		'OPEN_TRADES',
	// 		'CLOSE_TRADES'
	// 	];
	// 	$table_info = DB::select( "PRAGMA TABLE_INFO(TM_USER)" );
	// 	$table_info_array = array();
	// 	$i = 0;
	// 	foreach ( $table_info as $ti ) {
	// 		$table_info_array[$i] = $ti->name;
	// 		$i++;
	// 	}

	// 	$this->assertEquals( $table_info_default_array, $table_info_array );
	// }

	public function testRegistrationForm() {
		$response = $this->get( '/register' );
		$response->assertStatus( 200 );
	}

	// public function testRegistrationProcess() {
	// 	$random_number = rand( 10000000, 99999999 );
	// 	$response = $this->withHeaders( [
	// 		'X-CSRF-TOKEN' => csrf_token(),
	// 	] )->json( 'POST', '/register', [
	// 		'NAME' => 'Fake User',
	// 		'SURNAME' => 'Ke '.$random_number,
	// 		'PHONE_NUMBER' => '+62895'.$random_number,
	// 		'EMAIL' => 'fakeuser.'.$random_number.'@email.com',
	// 		'DOB' => '1993-11-26',
	// 		'PASSWORD' => 'fakeuser',
	// 	] );
	// 	$response->assertStatus( 200 );
	// }

}