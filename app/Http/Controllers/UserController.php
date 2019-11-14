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

class UserController extends Controller {

	public function __construct() {
		// ..
	}

	public function index() {
		return view( 'user/index' );
	}

	public function user_create_form( Request $req ) {
		$data['role_data'] = DB::select( "SELECT * FROM TM_ROLE" );
		$data['create_status'] = ( isset( $req->create_status ) ? $req->create_status : false );
		return view( 'user/create-form', $data );
	}

	public function user_create_process( Request $request ) {
		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'ROLE_ID' => 'required',
			'EMAIL' => 'required|email|max:320',
			'PASSWORD' => 'required|min:6|required_with:PASSWORD_CONF|same:PASSWORD_CONF',
			'PASSWORD_CONF' => 'min:6'
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
			return redirect( 'create-user' )->withErrors( $validator )->withInput();
		}
		else {
			$IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
			$IN_ROLE_ID = addslashes( $request->input( 'ROLE_ID' ) );
			$IN_PASSWORD = md5( addslashes( $request->input( 'PASSWORD' ) ) );
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
					return redirect( 'create-user?create_status=true' );
				}
				else {
					return redirect( 'create-user' )->withErrors( $validator )->withInput();
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				return abort( 500 );
			}
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