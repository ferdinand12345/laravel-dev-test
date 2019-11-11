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

class DashboardController extends Controller {
	
	public function __construct() {
		// ..
	}

	public function index( Request $req ) {
		print 'Hehehe';
		$session = $req->session()->get( 'login_data' );
		print_r($session);
		/*
		$sql_statement = ( "
			INSERT INTO 
				nbh.tm_user(
					id, 
					name, 
					surname, 
					date_of_birth, 
					phone_number, 
					password, 
					email
				) 
			VALUES (
				NULL, 
				'a', 
				NULL, 
				'2019-11-07', 
				'', 
				MD5( '12345' ),
				'ferdshinodas@gmail.com'
			)
		" );

		try {
			$run_query = DB::insert( $sql_statement );
			if ( $run_query == true ) {
				print 'Success';
			}
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			dd( $exception->getMessage() );
			print 'Oops Error';
		}
		*/
	}
}