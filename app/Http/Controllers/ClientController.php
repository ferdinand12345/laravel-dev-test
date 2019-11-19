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
			$data['client'] = collect( \DB::select( "
				SELECT
					A.ID,
					A.NAME,
					A.SURNAME,
					STRFTIME( '%d/%m/%Y', A.DOB ) AS DOB,
					A.EMAIL,
					A.PHONE_NUMBER,
					A.ADDRESS,
					A.COUNTRY,
					A.TRADING_ACCOUNT_NUMBER,
					A.BALANCE
				FROM
					TM_CLIENT A
				WHERE
					A.ID = '{$request->id}'
			" ) )->first();

			// print_r($data); dd();
			return view( 'client.edit-form', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			return abort( 500 );
		}
	}

	public function edit_process( Request $request ) {
		try {
			$data = array();
			$IN_ID = $request->id;
			$IN_NAME = addslashes( $request->input( 'NAME' ) );
			$IN_SURNAME = addslashes( $request->input( 'SURNAME' ) );
			$IN_DOB = addslashes( $request->input( 'DOB' ) );
			$IN_EMAIL = addslashes( $request->input( 'EMAIL' ) );
			$IN_PHONE_NUMBER = addslashes( $request->input( 'PHONE_NUMBER' ) );
			$IN_ADDRESS = addslashes( $request->input( 'ADDRESS' ) );
			$IN_COUNTRY = addslashes( $request->input( 'COUNTRY' ) );
			$IN_TRADING_ACCOUNT_NUMBER = addslashes( $request->input( 'TRADING_ACCOUNT_NUMBER' ) );
			$IN_BALANCE = addslashes( $request->input( 'BALANCE' ) );
			$IN_OPEN_TRADES = addslashes( $request->input( 'OPEN_TRADES' ) );
			$IN_CLOSE_TRADES = addslashes( $request->input( 'CLOSE_TRADES' ) );
			$run_query = DB::update( "
				UPDATE
					TM_CLIENT
				SET 
					NAME = '{$IN_NAME}', 
					SURNAME = '{$IN_SURNAME}', 
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

			print '<pre>';
			print_r( $query );
			print '<pre>';

			// return view( 'dashboard.index', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			return abort( 500 );
		}
	}
}