<?php

use Illuminate\Database\Seeder;

class tm_contact_seeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		for( $i = 0; $i <= 10000; $i++ ) {
			$random_phone_number = rand( 100000000000, 999999999999 );
			$random_zip_code = rand( 10000, 99999 );
			$query_insert_contact = DB::table( 'TM_CONTACT' )->insert( [
				"ID" => NULL,
				"AVATAR" => "assets/images/default-avatar.png",
				"FIRSTNAME" => Str::random( 40 ),
				"LASTNAME" => Str::random( 40 ),
				"EMAIL" => Str::random( 30 )."@gmail.com",
				"ADDRESS" => Str::random( 125 ),
				"COUNTRY_ID" => 2,
				"CITY_NAME" => "Azkaban",
				"ZIP_CODE" => (String) $random_zip_code,
				"PHONE_NUMBER" => (String) $random_phone_number,
				"NOTE" => Str::random( 2000 )
			] );
			$insert_id = DB::getPdo()->lastInsertId();
			// print $insert_id;
			$array_group = [
				"FAMILY", 
				"FRIENDS",
				"WORK",
				"FOOD",
				"FITNESS",
				"BADMINTON",
				"DRINK",
				"DISCO",
				"TRAVELING",
				"FISHING",
				"HUNTING",
				"CHURCH",
				"DANCING",
				"READING",
				"GOLF",
				"SWIMMING"
			];
			$random_group = array_rand( $array_group );
			print $array_group[$random_group].PHP_EOL;
			$query_insert_contact_group = DB::table( 'TM_CONTACT_GROUPS' )->insert( [
				'ID' => NULL,
				'NAME' => $array_group[$random_group],
				'CONTACT_ID' => $insert_id
			] );
			
			
		}
	}
}