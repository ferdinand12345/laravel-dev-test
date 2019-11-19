<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class TaskTest extends TestCase {

	public function test_db_connection() {
		try {
			DB::connection( DB::getDefaultConnection() )->reconnect();
			$this->assertTrue( true );
		}
		catch( \Exception $e ) {
			$this->assertTrue( false );
		}
	}

	public function test_db_column_check_tm_user() {
		$table_info_default_array = [
			'ID',
			'NAME',
			'SURNAME',
			'DOB',
			'EMAIL',
			'PASSWORD',
			'PHONE_NUMBER',
			'ADDRESS',
			'COUNTRY',
			'TRADING_ACCOUNT_NUMBER',
			'BALANCE',
			'OPEN_TRADES',
			'CLOSE_TRADES'
		];
		$table_info = DB::select( "PRAGMA TABLE_INFO(TM_USER)" );
		$table_info_array = array();
		$i = 0;
		foreach ( $table_info as $ti ) {
			$table_info_array[$i] = $ti->name;
			$i++;
		}

		$this->assertEquals( $table_info_default_array, $table_info_array );
	}

	public function test_dashboard_with_login() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1
				]
			] )
			->get( '/dashboard' )
			->assertStatus( 200 );
	}

	public function test_dashboard_without_login() {
		$response = $this->get( '/dashboard' )
			->assertRedirect( '/register' );
	}

	public function test_registration_form() {
		$response = $this->get( '/register' )
			->assertStatus( 200 );
	}

	public function test_login_form() {
		$response = $this->get( '/login' )
			->assertStatus( 200 );
	}

	public function test_login_process() {
		$response = $this->followingRedirects()
			->post( '/login', [
				'EMAIL' => 'ferdshinodas@gmail.com',
				'PASSWORD' => '123'
			] )
			->assertStatus( 200 );
	}

}