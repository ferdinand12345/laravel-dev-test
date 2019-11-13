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
			$query = DB::select( "
				SELECT 
					ID, 
					NAME, 
					SURNAME, 
					DATE( DOB ) AS DOB, 
					EMAIL, 
					PHONE_NUMBER,
					ADDRESS,
					COUNTRY,
					TRADING_ACCOUNT_NUMBER,
					BALANCE,
					OPEN_TRADES,
					CLOSE_TRADES
				FROM 
					TM_CLIENT
				ORDER BY
					NAME ASC,
					SURNAME ASC
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

	public function edit_form() {

	}

	public function edit_process() {
		try {
			$data = array();
			$IN_ID = '';
			$IN_NAME = '';
			$IN_SURNAME = '';
			$IN_DOB = '';
			$IN_EMAIL = '';
			$IN_PHONE_NUMBER = '';
			$IN_ADDRESS = '';
			$IN_COUNTRY = '';
			$IN_TRADING_ACCOUNT_NUMBER = '';
			$IN_BALANCE = '';
			$IN_OPEN_TRADES = '';
			$IN_CLOSE_TRADES = '';
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