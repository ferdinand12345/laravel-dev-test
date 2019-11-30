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

class ContactsController extends Controller {

	public function __construct() {
		// ..
	}

	public function index() {
		return view( 'contacts.index' );
	}

	public function create_form() {
		try {
			$data = array();
			$data['country_data'] = DB::select( "
				SELECT
					ID,
					NAME || ' (' || ISO_CODE || ')' AS NAME
				FROM
					TM_COUNTRY
				ORDER BY
					NAME ASC
			" );

			return view( 'contacts.create-form', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			return abort( 500 );
		}
	}

	public function create_process( Request $request ) {

		$IN_FIRSTNAME = addslashes( $request->input( 'FIRSTNAME' ) );
		$IN_LASTNAME = addslashes( $request->input( 'LASTNAME' ) );
		$IN_EMAIL =  addslashes( $request->input( 'EMAIL' ) );
		$IN_ADDRESS =  addslashes( $request->input( 'ADDRESS' ) );
		$IN_COUNTRY_ID =  addslashes( $request->input( 'COUNTRY_ID' ) );
		$IN_CITY_NAME =  addslashes( $request->input( 'CITY_NAME' ) );
		$IN_ZIP_CODE =  addslashes( $request->input( 'ZIP_CODE' ) );
		$IN_PHONE_NUMBER =  addslashes( $request->input( 'PHONE_NUMBER' ) );
		$IN_NOTE = addslashes( $request->input( 'NOTE' ) );

		$sql_statement = ( "
			INSERT INTO 
				TM_CONTACT(
					ID, 
					FIRSTNAME,
					LASTNAME,
					EMAIL,
					ADDRESS,
					COUNTRY_ID,
					CITY_NAME,
					ZIP_CODE,
					PHONE_NUMBER,
					NOTE
				) 
			VALUES (
				NULL, 
				'{$IN_FIRSTNAME}', 
				'{$IN_LASTNAME}', 
				'{$IN_EMAIL}', 
				'{$IN_ADDRESS}', 
				{$IN_COUNTRY_ID}, 
				'{$IN_CITY_NAME}', 
				'{$IN_ZIP_CODE}', 
				'{$IN_PHONE_NUMBER}', 
				'{$IN_NOTE}'
			)
		" );

		//try {
			$run_query = DB::insert( $sql_statement );
			if ( $run_query == true ) {
				print 'Okay';
				// return redirect( 'create-user?create_status=true' );
			}
			else {
				print 'Error cuys';
				// return redirect( 'create-user' )->withErrors( $validator )->withInput();
			}
		//} 
		//catch( \Illuminate\Database\QueryException $exception ) { 
		//	return abort( 500 );
		//}
	}
}