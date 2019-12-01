<?php

use Illuminate\Database\Seeder;

class tm_contact_seeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		print 'Please wait, the system is filling 10,000 dummy data...'.PHP_EOL;
		for( $i = 1; $i <= 10000; $i++ ) {
			$random_phone_number = rand( 1000000000, 9999999999 );
			$random_zip_code = rand( 10000, 99999 );
			$string_lorem_ipsum = addslashes( "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? 1914 translation by H. Rackham. But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure? except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences." );
			$query_insert_contact = DB::table( 'TM_CONTACT' )->insert( [
				"ID" => NULL,
				"AVATAR" => "assets/images/default-avatar.png",
				"FIRSTNAME" => Str::random( 40 ),
				"LASTNAME" => Str::random( 40 ),
				"EMAIL" => Str::random( 30 )."@gmail.com",
				"ADDRESS" => 'Nasim Strong Ap #630-3889 Nulla. Street Watervliet Oklahoma',
				"COUNTRY_ID" => 2,
				"CITY_NAME" => "Azkaban",
				"ZIP_CODE" => (String) $random_zip_code,
				"PHONE_NUMBER" => (String) $random_phone_number,
				"NOTE" => $string_lorem_ipsum
			] );
			$insert_id = DB::getPdo()->lastInsertId();
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
			$query_insert_contact_group = DB::table( 'TM_CONTACT_GROUPS' )->insert( [
				'ID' => NULL,
				'NAME' => $array_group[$random_group],
				'CONTACT_ID' => $insert_id
			] );
		}
	}
}