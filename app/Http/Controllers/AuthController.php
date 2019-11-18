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

	public function login_form() {
		return view( 'auth/login-form' );
	}

	public function login_process( Request $request ) {

		print '<pre>';
		print_r( $_POST );
		print '</pre>';
		dd();

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

	public function check_session() {
		$data = session()->all();
		print '<pre>';
		print_r($data);
		print '</pre>';
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