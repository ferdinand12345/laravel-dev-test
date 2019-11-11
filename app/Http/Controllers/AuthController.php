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

		# Default Response
		$response = array();
		$response['http_status_code'] = 401;
		$response['message'] = 'Unauthorized';
		$response['data'] = array();

		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'NAME' => 'required|max:64',
			'SURNAME' => 'max:64',
			'EMAIL' => 'required|regex:/^.+@.+$/i',
			'PASSWORD' => 'required|min:6|max:32',
			'PHONE_NUMBER' => 'required'
		] );

		if ( $validator->fails() ) {
			#return redirect( 'post/create' )
			#			->withErrors($validator)
			#			->withInput();
			print_r($validator->messages());
			return response()->json( $response );
		}
		else {
			$IN_NAME = $request->input( 'NAME' );
			$IN_SURNAME = $request->input( 'SURNAME' );
			$IN_PHONE_NUMBER = $request->input( 'PHONE_NUMBER' );
			$IN_EMAIL = $request->input( 'EMAIL' );
			$IN_DOB = date( 'Y-m-d H:i:s', strtotime( $request->input( 'DOB' ) ) );
			$IN_PASSWORD = md5( $request->input( 'PASSWORD' ) );

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
					$response['http_status_code'] = 200;
					$response['message'] = 'OK';
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				// dd( $exception->getMessage() );
				$response['http_status_code'] = 500;
				$response['message'] = 'Internal Server Error';
			}

			return response()->json( $response );
		}
	}

	public function login_process( Request $req ) {
		# Set Default Response Data
		$response = array();
		$response['http_status_code'] = 401;
		$response['message'] = 'Unauthorized';
		$response['data'] = array();

		print 'Hehehe';
		$email = 'ferdshinodas@gmail.com';
		$password = md5( '12345' );
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

		return response()->json( $response );
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
}