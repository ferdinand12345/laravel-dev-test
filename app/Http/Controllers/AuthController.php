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
		if( session()->has( 'LOGIN_DATA' ) ) {
			return abort( 404 );
		}
	}

	/*
	public function register_form() {
		return view( 'auth/register-form' );
	}

	public function register_process( Request $request ) {
		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'NAME' => 'required|max:64',
			'SURNAME' => 'max:64',
			'EMAIL' => 'required|email|max:320',
			'PASSWORD' => 'required|min:6|required_with:PASSWORD_CONF|same:PASSWORD_CONF',
			'PASSWORD_CONF' => 'min:6',
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

	public function login_process( Request $request ) {
		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'EMAIL' => 'required|email|max:320',
			'PASSWORD' => 'required|min:6'
		] );

		# Setup Custom Validation - Check Email Address
		$check_email = self::check_email( $request->input( 'EMAIL' ) );
		$validator->after( function( $validator ) use ( $check_email ) {
			if ( $check_email->COUNT == 0 ) {
				$validator->errors()->add( 'EMAIL', 'Your email or password is wrong.' );
			}
		} );

		# Run Validation
		if ( $validator->fails() ) {
			return redirect( 'login' )->withErrors( $validator )->withInput();
		}
		else {
			$IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
			$IN_PASSWORD = md5( addslashes( $request->input( 'PASSWORD' ) ) );
			$sql_statement = ( "
				SELECT 
					ID
				FROM 
					TM_USER
				WHERE 
					EMAIL = '{$IN_EMAIL}' 
					AND PASSWORD = '{$IN_PASSWORD}'
				LIMIT 1
			" );

			$run_query = collect( \DB::select( $sql_statement ) )->first();

			if ( !empty( $run_query ) ) {
				$set_login = $request->session()->put( [
					'LOGIN_DATA' => array(
						'ID' => $run_query->ID
					)
				] );
				if ( !$set_login ) {
					return redirect( 'dashboard' );
				}
				else {
					return redirect( 'login' )->withInput();
				}
			}
			else {
				return abort( 500 );
			}
		}
		
	}

	public function logout_process() {
		session()->flush();
		return redirect( 'login' );
	}

	private function check_email( $email, $password = '' ) {
		# Get TRUE/FALSE from TM_USER by Email Address
		$email = addslashes( $email );
		$password = ( $password == '' ? '' : "AND PASSWORD = '".md5( addslashes( $password ) )."'" );
		$query = collect( \DB::select( "
			SELECT 
				COUNT( 1 ) AS COUNT
			FROM 
				TM_USER 
			WHERE 
				EMAIL = '{$email}'
				{$password}
		" ) )->first();
		return $query;
	}
	*/

	public function login_process( Request $request ) {
		// $IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
		// $IN_PASSWORD = md5( addslashes( $request->input( 'PASSWORD' ) ) );
		$IN_EMAIL = 'admin@email.com';
		$IN_PASSWORD = md5( '1234567890' );
		$sql_statement = ( "
			SELECT 
				A.ID,
				A.EMAIL,
				A.ROLE_ID,
				B.NAME AS ROLE_NAME
			FROM 
				TM_USER A
				INNER JOIN TM_ROLE B
					ON A.ROLE_ID = B.ID
			WHERE 
				A.EMAIL = '{$IN_EMAIL}' 
				AND A.PASSWORD = '{$IN_PASSWORD}'
			LIMIT 1
		" );

		$run_query = collect( \DB::select( $sql_statement ) )->first();

		if ( !empty( $run_query ) ) {
			$set_login = $request->session()->put( [
				'LOGIN_DATA' => array(
					'ID' => $run_query->ID,
					'ROLE_ID' => $run_query->ROLE_ID,
					'ROLE_NAME' => $run_query->ROLE_NAME,
					'EMAIL' => $run_query->EMAIL
				)
			] );
			if ( !$set_login ) {
				print 'OK';
				// return redirect( 'dashboard' );
			}
			else {
				print 'Gak OK';
				// return redirect( 'login' )->withInput();
			}
		}
		else {
			print 'Internal Server Error';
			// return abort( 500 );
		}
	}

	public function logout_process() {
		session()->flush();
		// return redirect( 'login' );
		print 'Done';
	}

	public function check_session() {
		$data = session()->all();
		print '<pre>';
		print_r($data);
		print '</pre>';
	}

	public function user_create_form( Request $req ) {
		return view( 'auth/user-create-form' );
	}

	public function user_create_process( Request $req ) {

		// $IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
		// $IN_ROLE_ID = addslashes( $request->input( 'ROLE_ID' ) );
		// $IN_PASSWORD = md5( addslashes( $request->input( 'PASSWORD' ) ) );

		print '<pre>';
		print_r( $_POST );
		print '</pre>';
		dd();

		$IN_EMAIL = 'xxx@email.com';
		$IN_ROLE_ID = 2;
		$IN_PASSWORD = md5( '1234567890' );
		$check_email = self::check_email( $IN_EMAIL );

		if ( $check_email->COUNT == 0 ) {
			$sql_statement = ( "
				INSERT INTO 
					TM_USER(
						ID, 
						EMAIL, 
						PASSWORD, 
						ROLE_ID
					) 
				VALUES (
					NULL, 
					'{$IN_EMAIL}', 
					'{$IN_PASSWORD}',
					'{$IN_ROLE_ID}'
				)
			" );

			try {
				$run_query = DB::insert( $sql_statement );
				if ( $run_query == true ) {
					// }
					print 'OK';
				}
				else {
					create-user
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				// return abort( 500 );
				print 'Internal Server Error';
			}
		}
		else {
			print 'Email Tidak tersedia';
		}
	}

	private function check_email( $email, $password = '' ) {
		# Get TRUE/FALSE from TM_USER by Email Address
		$email = addslashes( $email );
		$password = ( $password == '' ? '' : "AND PASSWORD = '".md5( addslashes( $password ) )."'" );
		$query = collect( \DB::select( "
			SELECT 
				COUNT( 1 ) AS COUNT
			FROM 
				TM_USER 
			WHERE 
				EMAIL = '{$email}'
				{$password}
		" ) )->first();
		return $query;
	}

}