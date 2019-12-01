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
use DataTables;

class ContactsController extends Controller {

	public function __construct() {
		// ..
	}

	public function index() {
		try{
			$data['group_data'] = DB::select( "
				SELECT NAME
				FROM TM_CONTACT_GROUPS
				GROUP BY NAME
				ORDER BY NAME ASC
			" );
			return view( 'contacts.index', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}

	public function data( Request $request ) {

		
		$rowdata = collect( \DB::select( "SELECT COUNT(*) AS RESULT FROM TM_CONTACT" ) )->first();
		$records_filtered_min = $rowdata->RESULT;

		// print_r($rowdata);
		// dd();

		# Query Limitation
		$start = intval( $_POST['start'] );
		$length = intval( $_POST['length'] );
		$where_limit = "LIMIT {$start},{$length}";

		# Query Search by User Request
		$where_search = "";
		if( isset( $_POST['search']['value'] ) ) {
			if ( $_POST['search']['value'] != '' ) {
				$search_value = addslashes( $_POST['search']['value'] );
				$where_search .= "AND A.FIRSTNAME LIKE '%{$search_value}%' ";
				$where_search .= "OR A.LASTNAME LIKE '%{$search_value}%' ";
				$where_search .= "OR A.EMAIL LIKE '%{$search_value}%' ";
				$where_search .= "OR B.NAME LIKE '%{$search_value}%' ";
				$where_search .= "OR A.PHONE_NUMBER LIKE '%{$search_value}%' ";
				$where_search .= "OR A.ZIP_CODE LIKE '%{$search_value}%' ";
				$where_search .= "OR CONCAT( '+', B.PHONE_CODE, ' ', SUBSTR( A.PHONE_NUMBER, 2, 15 ) ) LIKE '%{$search_value}%' ";
				$where_search .= "OR CONCAT( '+', B.PHONE_CODE, ' ', A.PHONE_NUMBER ) LIKE '%{$search_value}%' ";
				$where_search .= "OR CONCAT( '+', B.PHONE_CODE, SUBSTR( A.PHONE_NUMBER, 2, 15 ) ) LIKE '%{$search_value}%' ";
				$where_search .= "OR CONCAT( '+', B.PHONE_CODE, A.PHONE_NUMBER ) LIKE '%{$search_value}%' ";
			}
		}

		$where_groups_2 = '';
		if( isset( $_GET['group'] ) ) {
			$search_group = $_GET['group'];
			
			if ( $search_group != '' ) {
				$where_groups_2 = "AND C.NAME = '{$search_group}' ";
				$where_groups_1 = "AND B.NAME = '{$search_group}' ";
				$rowdata = collect( \DB::select( "
					SELECT 
						COUNT( 1 ) AS RESULT 
					FROM 
						TM_CONTACT A
						INNER JOIN TM_CONTACT_GROUPS B
							ON B.CONTACT_ID = A.ID
					WHERE
						1 = 1
						$where_groups_1

				" ) )->first();
				$records_filtered_min = $rowdata->RESULT;
			}
		}

		$query = DB::select( "
			SELECT
				A.ID,
				A.AVATAR,
				A.FIRSTNAME,
				A.LASTNAME,
				A.EMAIL,
				CONCAT( B.NAME, ' (', B.ISO_CODE, ')' ) AS COUNTRY_NAME,
				A.CITY_NAME,
				A.ZIP_CODE,
				CASE
					WHEN SUBSTR( A.PHONE_NUMBER, 1, 1 ) = '0'
					THEN CONCAT( '+', B.PHONE_CODE, ' ', SUBSTR( A.PHONE_NUMBER, 2, 15 ) )
					ELSE CONCAT( '+', B.PHONE_CODE, ' ', A.PHONE_NUMBER )
				END AS PHONE_NUMBER,
				C.NAME AS GROUPS
			FROM
				TM_CONTACT A
				INNER JOIN TM_COUNTRY B ON B.ID = A.COUNTRY_ID
				LEFT JOIN(
					SELECT
						CONTACT_ID,
						GROUP_CONCAT( NAME ) AS NAME
					FROM
						TM_CONTACT_GROUPS
					GROUP BY
						NAME,
						CONTACT_ID
					ORDER BY
						NAME ASC
				) C ON C.CONTACT_ID = A.ID
			WHERE
				1 = 1 
				$where_search
				$where_groups_2
			ORDER BY
				A.ID ASC
			$where_limit
		" );

		return Datatables::of( $query )
			->with( [
				"recordsTotal" => intval( $rowdata->RESULT ),
				"recordsFiltered" => $records_filtered_min,
				"data" => $query
			] )
			->toJson();
	}

	public function create_form() {
		try{
			$data = array();
			$data['country_data'] = DB::select( "
				SELECT
					ID,
					CONCAT( NAME, ' (', ISO_CODE, ')' ) AS NAME
				FROM
					TM_COUNTRY
				ORDER BY
					NAME ASC
			" );

			return view( 'contacts.create-form', $data );
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}

	public function create_process( Request $request ) {

		# Upload Files
		$IN_AVATAR_FULLPATH = 'assets/images/default-avatar.png'; // Default Avatar if upload doesn't exists.
		if( $request->hasFile( 'AVATAR' ) ) {
			try {
				$IN_AVATAR = $request->file( 'AVATAR');
				$IN_AVATAR_FILENAME = 'AVATAR-ID-'.time().'.'.$IN_AVATAR->getClientOriginalExtension();
				$IN_AVATAR_FULLPATH = 'assets/images/'.$IN_AVATAR_FILENAME;
				$IN_AVATAR->move( public_path( 'assets/images/user-upload' ), $IN_AVATAR_FULLPATH );
			}
			catch( Exception $exception ){
				print 'Exception: '.$exception->getMessage();
			}
		}

		# Insert To Contact
		$IN_FIRSTNAME = addslashes( $request->input( 'FIRSTNAME' ) );
		$IN_LASTNAME = addslashes( $request->input( 'LASTNAME' ) );
		$IN_EMAIL =  addslashes( $request->input( 'EMAIL' ) );
		$IN_ADDRESS =  addslashes( $request->input( 'ADDRESS' ) );
		$IN_COUNTRY_ID =  addslashes( $request->input( 'COUNTRY_ID' ) );
		$IN_CITY_NAME =  addslashes( $request->input( 'CITY_NAME' ) );
		$IN_ZIP_CODE =  addslashes( $request->input( 'ZIP_CODE' ) );
		$IN_PHONE_NUMBER =  addslashes( $request->input( 'PHONE_NUMBER' ) );
		$IN_NOTE = addslashes( $request->input( 'NOTE' ) );

		DB::beginTransaction();
		$sql_statement = ( "
			INSERT INTO 
				TM_CONTACT(
					ID, 
					AVATAR,
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
				'{$IN_AVATAR_FULLPATH}', 
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

		try{
			$run_query = DB::insert( $sql_statement );
			if ( $run_query == true ) {

				# Insert Group
				$IN_GROUPS = $request->input( 'GROUPS' );
				$IN_GROUPS_DATA = array();
				$IN_GROUPS_ERROR = array();
				$i = 0;
				foreach( $IN_GROUPS as $group ) {
					try {
						$query_insert = DB::insert( "
							INSERT INTO
								TM_CONTACT_GROUPS(
									ID, NAME, CONTACT_ID
								)
							VALUES(
								NULL, UPPER( '{$group}' ), 1
							)
						" );
						if ( $query_insert != true ) {
							$IN_GROUPS_ERROR[$i] = $group;
						}
					}
					catch( \Illuminate\Database\QueryException $exception ) { 
						$IN_GROUPS_ERROR[$i] = $group;
					}
					$i++;
				}

				if ( empty( $IN_GROUPS_ERROR ) ) {
					DB::commit();
					print 'Okay';
				}
				else {
					DB::rollBack();
					print 'Error cuys1';
				}
				// return redirect( 'create-user?create_status=true' );
			}
			else {
				DB::rollBack();
				print 'Error cuys2';
				// return redirect( 'create-user' )->withErrors( $validator )->withInput();
			}
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}
}