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
		$session_id = session( 'LOGIN_DATA' )['ID'];
		$data = array();
		$data['userdata'] = collect( \DB::select( "
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
				TM_USER
			WHERE
				ID = '{$session_id}'
		" ) )->first();
		return view( 'dashboard.index', $data );
	}
}