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

	public function test_db_column_check_tm_client() {
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
		$table_info = DB::select( "PRAGMA TABLE_INFO(TM_CLIENT)" );
		$table_info_array = array();
		$i = 0;
		foreach ( $table_info as $ti ) {
			$table_info_array[$i] = $ti->name;
			$i++;
		}

		$this->assertEquals( $table_info_default_array, $table_info_array );
	}

	public function test_db_column_check_tm_role() {
		$table_info_default_array = [
			'ID',
			'NAME'
		];
		$table_info = DB::select( "PRAGMA TABLE_INFO(TM_ROLE)" );
		$table_info_array = array();
		$i = 0;
		foreach ( $table_info as $ti ) {
			$table_info_array[$i] = $ti->name;
			$i++;
		}

		$this->assertEquals( $table_info_default_array, $table_info_array );
	}

	public function test_db_column_check_tm_user() {
		$table_info_default_array = [
			'ID',
			'EMAIL',
			'PASSWORD',
			'ROLE_ID'
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

	public function test_dashboard_without_login() {
		$response = $this->get( '/dashboard' )
			->assertRedirect( '/login' );
	}

	public function test_dashboard_with_login() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1,
					'ROLE_ID' => 1,
					'ROLE_NAME' => 'ADMIN',
					'EMAIL' => 'admin@email.com'
				]
			] )
			->get( '/dashboard' )
			->assertStatus( 200 );
	}

	public function test_user_index_with_login_admin() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1,
					'ROLE_ID' => 1,
					'ROLE_NAME' => 'ADMIN',
					'EMAIL' => 'admin@email.com'
				]
			] )
			->get( '/user' )
			->assertStatus( 200 );
	}

	public function test_user_create_with_login_admin() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1,
					'ROLE_ID' => 1,
					'ROLE_NAME' => 'ADMIN',
					'EMAIL' => 'admin@email.com'
				]
			] )
			->get( '/create-user' )
			->assertStatus( 200 );
	}

	public function test_user_create_with_login_user() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1,
					'ROLE_ID' => 2,
					'ROLE_NAME' => 'ADMIN',
					'EMAIL' => 'admin@email.com'
				]
			] )
			->get( '/user' )
			->assertStatus( 404 );
	}

	public function test_user_index_with_login_user() {
		$response = $this->withSession( [
				'LOGIN_DATA' => [
					'ID' => 1,
					'ROLE_ID' => 2,
					'ROLE_NAME' => 'ADMIN',
					'EMAIL' => 'admin@email.com'
				]
			] )
			->get( '/create-user' )
			->assertStatus( 404 );
	}

	// public function test_login_process() {
	// 	$response = $this->visit('/register')
	// 		->type( 'admin@email.com', 'EMAIL' )
	// 		->type( '1234567890', 'PASSWORD' )
	// 		->press( 'Login' )
	// 		->seePageIs( '/dashboard' );
	// }

}