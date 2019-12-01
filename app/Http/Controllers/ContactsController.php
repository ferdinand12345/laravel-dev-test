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

	public function data_detail( Request $request ) {
		# Default Response
		$data['status'] = false;
		$data['data'] = [
			"AVATAR" => "",
			"FIRSTNAME" => "",
			"LASTNAME" => "",
			"EMAIL" => "",
			"COUNTRY_NAME" => "",
			"CITY_NAME" => "",
			"ZIP_CODE" => "",
			"PHONE_NUMBER" => "",
			"GROUPS" => "",
			"ADDRESS" => "",
			"NOTE" => ""
		];

		try{
			$IN_ID = intval( $request->ID );
			$query = collect( \DB::select( "
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
					C.NAME AS GROUPS,
					A.ADDRESS,
					A.NOTE
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
					AND A.ID = {$IN_ID}
			" ) )->first();
			
			if( !empty( $query ) ) {
				$data['status'] = true;
				$data['data']['AVATAR'] = url( $query->AVATAR );
				$data['data']['FIRSTNAME'] = $query->FIRSTNAME;
				$data['data']['LASTNAME'] = $query->LASTNAME;
				$data['data']['EMAIL'] = $query->EMAIL;
				$data['data']['COUNTRY_NAME'] = $query->COUNTRY_NAME;
				$data['data']['CITY_NAME'] = $query->CITY_NAME;
				$data['data']['ZIP_CODE'] = $query->ZIP_CODE;
				$data['data']['PHONE_NUMBER'] = $query->PHONE_NUMBER;
				$data['data']['GROUPS'] = $query->GROUPS;
				$data['data']['ADDRESS'] = $query->ADDRESS;
				$data['data']['NOTE'] = $query->NOTE;
			}

			return response()->json( $data );
		}
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}

	public function delete_process( Request $request ) {
		try{
			$IN_ID = intval( $request->input( 'ID' ) );
			$data['status'] = false;
			$query_delete = DB::delete( "DELETE FROM TM_CONTACT WHERE ID = {$IN_ID}" );
			if( $query_delete == true ) {
				$data['status'] = true;
				DB::delete( "DELETE FROM TM_CONTACT_GROUPS WHERE CONTACT_ID = {$IN_ID}" );
			}

			return response()->json( $data );
		}
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}

	public function data( Request $request ) {

		$rowdata = collect( \DB::select( "SELECT COUNT(*) AS RESULT FROM TM_CONTACT" ) )->first();
		$records_filtered_min = $rowdata->RESULT;

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
				A.FIRSTNAME ASC,
				A.LASTNAME ASC
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

	public function edit_form( Request $request ) {
		try{
			$IN_ID = intval( $request->ID );
			$query = collect( \DB::select( "SELECT * FROM TM_CONTACT WHERE ID = {$IN_ID}" ) )->first();
			if( !empty( $query ) ) {
				$data = array();
				$data['q'] = $query;
				$data['country_data'] = DB::select( "
					SELECT
						ID,
						CONCAT( NAME, ' (', ISO_CODE, ')' ) AS NAME
					FROM
						TM_COUNTRY
					ORDER BY
						NAME ASC
				" );
				$data['groups_data'] = DB::select( "
					SELECT
						NAME
					FROM
						TM_CONTACT_GROUPS
					WHERE
						CONTACT_ID = {$IN_ID}
					ORDER BY
						NAME ASC
				" );

				return view( 'contacts.edit-form', $data );
			}
			else {
				return abort( 404 );
			}
		} 
		catch( \Illuminate\Database\QueryException $exception ) { 
			print 'Exception: '.$exception->getMessage();
		}
	}

	public function edit_process( Request $request ) {

		$IN_ID = intval( $request->ID );

		$validator = Validator::make( $request->all(), [
			'FIRSTNAME' => 'required|max:64',
			'LASTNAME' => 'required|max:64',
			'CITY_NAME' => 'required|max:64',
			'PHONE_NUMBER' => 'required|alpha_num|max:15',
			'ZIP_CODE' => 'required|alpha_num|max:10',
			'EMAIL' => 'required|email|max:320',
			'COUNTRY_ID' => 'required|integer'
		] );

		# Run Validation
		if ( $validator->fails() ) {
			print_r( $validator->errors() );
			// return redirect( 'contacts/edit/'.$IN_ID )->withErrors( $validator )->withInput();
		}
		else {
			# Upload Files
			$IN_AVATAR_FULLPATH = $request->input( 'CURRENT_AVATAR' ); // Default Avatar if upload doesn't exists.
			if( $request->hasFile( 'AVATAR' ) ) {
				try {
					$IN_AVATAR = $request->file( 'AVATAR');
					$IN_AVATAR_FILENAME = 'AVATAR-'.$IN_ID.'-'.time().'.'.$IN_AVATAR->getClientOriginalExtension();
					$IN_AVATAR_FULLPATH = 'assets/images/user-upload/'.$IN_AVATAR_FILENAME;
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
				UPDATE 
					TM_CONTACT 
				SET
					AVATAR = '{$IN_AVATAR_FULLPATH}', 
					FIRSTNAME = '{$IN_FIRSTNAME}', 
					LASTNAME = '{$IN_LASTNAME}',
					EMAIL = '{$IN_EMAIL}', 
					ADDRESS = '{$IN_ADDRESS}', 
					COUNTRY_ID = {$IN_COUNTRY_ID}, 
					CITY_NAME = '{$IN_CITY_NAME}', 
					ZIP_CODE = '{$IN_ZIP_CODE}', 
					PHONE_NUMBER = '{$IN_PHONE_NUMBER}', 
					NOTE = '{$IN_NOTE}'
				WHERE
					ID = {$IN_ID}
			" );

			try{
				$run_query = DB::update( $sql_statement );
				if ( $run_query == true ) {
					
					# Delete Group
					DB::delete( "DELETE FROM TM_CONTACT_GROUPS WHERE CONTACT_ID = {$IN_ID}" );

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
									NULL, UPPER( '{$group}' ), {$IN_ID}
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
					}
					else {
						DB::rollBack();
					}
					// return redirect( 'create-user?create_status=true' );
				}
				else {
					DB::rollBack();
					print 'Error cuys2';
					return redirect( 'create-user' )->withErrors( $validator )->withInput();
				}
			} 
			catch( \Illuminate\Database\QueryException $exception ) { 
				print 'Exception: '.$exception->getMessage();
			}
		}
	}

	public function create_process( Request $request ) {

		# Upload Files
		$IN_AVATAR_FULLPATH = 'assets/images/default-avatar.png'; // Default Avatar if upload doesn't exists.
		if( $request->hasFile( 'AVATAR' ) ) {
			try {
				$IN_AVATAR = $request->file( 'AVATAR');
				$IN_AVATAR_FILENAME = 'AVATAR-ID-'.time().'.'.$IN_AVATAR->getClientOriginalExtension();
				$IN_AVATAR_FULLPATH = 'assets/images/user-upload/'.$IN_AVATAR_FILENAME;
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