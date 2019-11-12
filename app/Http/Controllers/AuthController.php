<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Session;
use Config;
use URL;
use Validator;

class AuthController extends Controller {
	
	public function __construct() {
		// ..
	}

	public function register_form() {
		return view( 'auth/register-form' );
	}

	public function register_process( Request $request ) {
		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'NAME' => 'required|max:64',
			'SURNAME' => 'max:64',
			'EMAIL' => 'required|email|max:320',
			'PASSWORD' => 'required|min:6|max:32',
			'PHONE_NUMBER' => 'required'
		] );

		# Setup Custom Validation - Check Email Address
		$check_email = self::check_email( $request->input( 'EMAIL' ) );
		$validator->after( function( $validator ) use ( $check_email ) {
			if ( $check_email->COUNT > 0 ) {
				$validator->errors()->add( 'EMAIL', 'The email is not available.');
			}
		} );

		# Run Validation
		if ( $validator->fails() ) {
			return redirect( 'register' )->withErrors( $validator )->withInput();
		}
		else {
			$IN_NAME = addslashes( $request->input( 'NAME' ) );
			$IN_SURNAME = addslashes( $request->input( 'SURNAME' ) );
			$IN_PHONE_NUMBER = addslashes( $request->input( 'PHONE_NUMBER' ) );
			$IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
			$IN_DOB = date( 'Y-m-d H:i:s', strtotime( addslashes( $request->input( 'DOB' ) ) ) );
			$IN_PASSWORD = md5( addslashes( $request->input( 'PASSWORD' ) ) );
			$sql_statement = ( "
				INSERT INTO 
					TM_USER(
						ID, 
						NAME, 
						SURNAME, 
						DOB, 
						EMAIL, 
						PASSWORD, 
						PHONE_NUMBER,
						ADDRESS,
						COUNTRY,
						TRADING_ACCOUNT_NUMBER,
						BALANCE,
						OPEN_TRADES,
						CLOSE_TRADES
					) 
				VALUES (
					NULL, 
					'{$IN_NAME}', 
					'{$IN_SURNAME}', 
					'{$IN_DOB}', 
					'{$IN_EMAIL}', 
					'{$IN_PASSWORD}',
					'{$IN_PHONE_NUMBER}',
					'10 Eunos Road 8, #05-33 Singapore Post Centre',
					'SG',
					'IN01234567891044',
					-100.22,
					211.299,
					211.299
				)
			" );

			try {
				$run_query = DB::insert( $sql_statement );
				if ( $run_query == true ) {
					$set_login = $request->session()->put( [
						'LOGIN_DATA' => array(
							'ID' => DB::getPdo()->lastInsertId()
						)
					] );
					if ( !$set_login ) {
						return redirect( 'dashboard' );
					}
					else {
						return redirect( 'register' )->withInput();
					}
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				return abort( 500 );
			}
		}
	}

	public function login_form() {
		return view( 'auth/login-form' );
	}

	public function login_process( Request $req ) {
		# Set Default Response Data
		$response = array();
		$response['http_status_code'] = 401;
		$response['message'] = 'Unauthorized';
		$response['data'] = array();

		$email = $req->input( 'email' );
		$password = md5( $req->input( 'password' ) );
		$sql_statement = ( "
			SELECT 
				ID
			FROM 
				TM_USER
			WHERE 
				EMAIL = '{$email}' 
				AND PASSWORD = '{$password}'
			LIMIT 1
		" );

		$run_query = collect( \DB::select( $sql_statement ) )->first();

		if ( !empty( $run_query ) ) {
			$req->session()->put( [
				'LOGIN_DATA' => array(
					'ID' => $run_query->ID
				)
			] );
			$response['http_status_code'] = 200;
			$response['message'] = 'OK';
		}
		else {
			$response['message'] = 'User not found';
		}

		return response()->json( $response );
	}

	public function logout_process() {
		session()->flush();
		return redirect( 'login' );
	}

	public function check_session( Request $req ) {
		print '<pre>';
		print_r( session()->all() );
		print '</pre>';
	}

	public function testing() {
		// $query = DB::select( "SELECT * FROM tm_user" );
		$query = DB::insert( "INSERT INTO tm_user VALUES( NULL, 'A', 'B' )" );
		print_r( $query );
	}

	private function check_email( $email ) {
		# Get TRUE/FALSE from TM_USER by Email Address
		$email = addslashes( $email );
		$query = collect( \DB::select( "
			SELECT 
				COUNT( 1 ) AS COUNT
			FROM 
				TM_USER 
			WHERE 
				EMAIL = '{$email}'
		" ) )->first();
		return $query;
	}

}