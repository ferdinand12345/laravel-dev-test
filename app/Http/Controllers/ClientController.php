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

class ClientController extends Controller {
	
	public function __construct() {
		// ..
	}

	public function index( Request $req ) {
		try {
			$data = array();
			$data['client_data'] = DB::select( "
				SELECT
					A.ID,
					A.NAME,
					A.SURNAME,
					DATE( A.DOB ) AS DOB,
					A.EMAIL
				FROM
					TM_CLIENT A
				ORDER BY
					A.NAME ASC,
					A.SURNAME ASC
			" );

			return view( 'client.index', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			return abort( 500 );
		}
	}

	public function edit_form( Request $request ) {
		try {
			$data = array();
			$data['country_data'] = [
				[ 'CODE' => 'CY', 'NAME' => 'Cyprus' ],
				[ 'CODE' => 'ID', 'NAME' => 'Indonesia' ],
				[ 'CODE' => 'SG', 'NAME' => 'Singapore' ]
			];
			$data['client'] = collect( \DB::select( "
				SELECT
					A.ID,
					A.NAME,
					A.SURNAME,
					STRFTIME( '%Y-%m-%d', A.DOB ) AS DOB,
					A.EMAIL,
					A.PHONE_NUMBER,
					A.ADDRESS,
					A.COUNTRY,
					A.TRADING_ACCOUNT_NUMBER,
					A.BALANCE,
					A.OPEN_TRADES,
					A.CLOSE_TRADES
				FROM
					TM_CLIENT A
				WHERE
					A.ID = '{$request->id}'
			" ) )->first();
			$data['save_status'] = ( isset( $request->save_status ) ? $request->save_status : false );

			return view( 'client.edit-form', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			return abort( 500 );
		}
	}

	public function edit_process( Request $request ) {
		# Setup Validation
		$validator = Validator::make( $request->all(), [
			'NAME' => 'required|max:64',
			'SURNAME' => 'max:64',
			'EMAIL' => 'required|email|max:320',
			'PASSWORD' => 'same:PASSWORD_CONF',
			'PHONE_NUMBER' => 'required',
			'ADDRESS' => 'required',
			'COUNTRY' => 'required|',
			'TRADING_ACCOUNT_NUMBER' => 'required|alpha_num|max:16',
			'BALANCE' => 'required|regex:/^\d+(\.\d{1,2})?$/',
			'OPEN_TRADES' => 'required|regex:/^\d+(\.\d{1,2})?$/',
			'CLOSE_TRADES' => 'required|regex:/^\d+(\.\d{1,2})?$/'
		] );

		# Setup Custom Validation - Check Email Address
		$check_email = self::check_email( $request->input( 'EMAIL' ), $request->id );
		$validator->after( function( $validator ) use ( $check_email ) {
			if ( $check_email->COUNT > 0 ) {
				$validator->errors()->add( 'EMAIL', 'The email is not available.');
			}
		} );

		# Run Validation
		if ( $validator->fails() ) {
			return redirect( 'client/'.$request->id.'?save_status=false' )->withErrors( $validator )->withInput();
		}
		else {
			try {
				$data = array();
				$IN_ID = $request->id;
				$IN_NAME = addslashes( $request->input( 'NAME' ) );
				$IN_SURNAME = addslashes( $request->input( 'SURNAME' ) );
				$IN_PASSWORD = ( $request->input( 'PASSWORD' ) != '' ? md5( addslashes( $request->input( 'PASSWORD' ) ) ) : '' );
				$IN_DOB = addslashes( $request->input( 'DOB' ) );
				$IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
				$IN_PHONE_NUMBER = addslashes( $request->input( 'PHONE_NUMBER' ) );
				$IN_ADDRESS = addslashes( $request->input( 'ADDRESS' ) );
				$IN_COUNTRY = addslashes( $request->input( 'COUNTRY' ) );
				$IN_TRADING_ACCOUNT_NUMBER = addslashes( $request->input( 'TRADING_ACCOUNT_NUMBER' ) );
				$IN_BALANCE = addslashes( $request->input( 'BALANCE' ) );
				$IN_OPEN_TRADES = addslashes( $request->input( 'OPEN_TRADES' ) );
				$IN_CLOSE_TRADES = addslashes( $request->input( 'CLOSE_TRADES' ) );
				$COND_PASSWORD = ( $IN_PASSWORD != '' ? "PASSWORD = '{$IN_PASSWORD}', " : "" );
				$run_query = DB::update( "
					UPDATE
						TM_CLIENT
					SET 
						NAME = '{$IN_NAME}', 
						SURNAME = '{$IN_SURNAME}', 
						$COND_PASSWORD
						DOB = '{$IN_DOB}', 
						EMAIL = '{$IN_EMAIL}', 
						PHONE_NUMBER = '{$IN_PHONE_NUMBER}',
						ADDRESS = '{$IN_ADDRESS}',
						COUNTRY = '{$IN_COUNTRY}',
						TRADING_ACCOUNT_NUMBER = '{$IN_TRADING_ACCOUNT_NUMBER}',
						BALANCE = '{$IN_BALANCE}',
						OPEN_TRADES = '{$IN_OPEN_TRADES}',
						CLOSE_TRADES = '{$IN_CLOSE_TRADES}'
					WHERE 
						ID = '{$IN_ID}'
				" );

				if ( $run_query == true ) {
					return redirect( 'client/'.$request->id.'?save_status=true' );
				}
				else {
					return abort( 500 );
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				return abort( 500 );
			}
		}
	}

	private function check_email( $email, $current_ID = '' ) {
		# Get TRUE/FALSE from TM_USER by Email Address
		$email = addslashes( $email );
		$current_ID = intval( $current_ID );
		$query = collect( \DB::select( "
			SELECT 
				COUNT( 1 ) AS COUNT
			FROM 
				TM_CLIENT 
			WHERE 
				EMAIL = '{$email}'
				AND ID NOT IN ( {$current_ID} )
		" ) )->first();

		return $query;
	}
}