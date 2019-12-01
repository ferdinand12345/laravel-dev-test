<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmCountryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'TM_COUNTRY', function ( Blueprint $table ) {
			$table->mediumIncrements( 'ID' );
			$table->string( 'ISO_CODE', 2 );
			$table->string( 'NAME', 100 );
			$table->string( 'PHONE_CODE', 10 );
		} );

		DB::table( 'TM_COUNTRY' )->insert(
			array(
				array( 'ISO_CODE' => 'AF', 'NAME' => 'Afghanistan', 'PHONE_CODE' => '93' ),
				array( 'ISO_CODE' => 'AL', 'NAME' => 'Albania', 'PHONE_CODE' => '355' ),
				array( 'ISO_CODE' => 'DZ', 'NAME' => 'Algeria', 'PHONE_CODE' => '213' ),
				array( 'ISO_CODE' => 'DS', 'NAME' => 'American Samoa', 'PHONE_CODE' => '1 684' ),
				array( 'ISO_CODE' => 'AD', 'NAME' => 'Andorra', 'PHONE_CODE' => '376' ),
				array( 'ISO_CODE' => 'AO', 'NAME' => 'Angola', 'PHONE_CODE' => '244' ),
				array( 'ISO_CODE' => 'AI', 'NAME' => 'Anguilla', 'PHONE_CODE' => '1 264' ),
				array( 'ISO_CODE' => 'AQ', 'NAME' => 'Antarctica', 'PHONE_CODE' => '672' ),
				array( 'ISO_CODE' => 'AG', 'NAME' => 'Antigua and Barbuda', 'PHONE_CODE' => '1 268' ),
				array( 'ISO_CODE' => 'AR', 'NAME' => 'Argentina', 'PHONE_CODE' => '54' ),
				array( 'ISO_CODE' => 'AM', 'NAME' => 'Armenia', 'PHONE_CODE' => '374' ),
				array( 'ISO_CODE' => 'AW', 'NAME' => 'Aruba', 'PHONE_CODE' => '297' ),
				array( 'ISO_CODE' => 'AU', 'NAME' => 'Australia', 'PHONE_CODE' => '61' ),
				array( 'ISO_CODE' => 'AT', 'NAME' => 'Austria', 'PHONE_CODE' => '43' ),
				array( 'ISO_CODE' => 'AZ', 'NAME' => 'Azerbaijan', 'PHONE_CODE' => '994' ),
				array( 'ISO_CODE' => 'BS', 'NAME' => 'Bahamas', 'PHONE_CODE' => '1 242' ),
				array( 'ISO_CODE' => 'BH', 'NAME' => 'Bahrain', 'PHONE_CODE' => '973' ),
				array( 'ISO_CODE' => 'BD', 'NAME' => 'Bangladesh', 'PHONE_CODE' => '880' ),
				array( 'ISO_CODE' => 'BB', 'NAME' => 'Barbados', 'PHONE_CODE' => '1 246' ),
				array( 'ISO_CODE' => 'BY', 'NAME' => 'Belarus', 'PHONE_CODE' => '375' ),
				array( 'ISO_CODE' => 'BE', 'NAME' => 'Belgium', 'PHONE_CODE' => '32' ),
				array( 'ISO_CODE' => 'BZ', 'NAME' => 'Belize', 'PHONE_CODE' => '501' ),
				array( 'ISO_CODE' => 'BJ', 'NAME' => 'Benin', 'PHONE_CODE' => '229' ),
				array( 'ISO_CODE' => 'BM', 'NAME' => 'Bermuda', 'PHONE_CODE' => '1 441' ),
				array( 'ISO_CODE' => 'BT', 'NAME' => 'Bhutan', 'PHONE_CODE' => '975' ),
				array( 'ISO_CODE' => 'BO', 'NAME' => 'Bolivia', 'PHONE_CODE' => '591' ),
				array( 'ISO_CODE' => 'BA', 'NAME' => 'Bosnia and Herzegovina', 'PHONE_CODE' => '387' ),
				array( 'ISO_CODE' => 'BW', 'NAME' => 'Botswana', 'PHONE_CODE' => '267' ),
				array( 'ISO_CODE' => 'BR', 'NAME' => 'Brazil', 'PHONE_CODE' => '55' ),
				array( 'ISO_CODE' => 'IO', 'NAME' => 'British Indian Ocean Territory', 'PHONE_CODE' => '246' ),
				array( 'ISO_CODE' => 'BN', 'NAME' => 'Brunei Darussalam', 'PHONE_CODE' => '673' ),
				array( 'ISO_CODE' => 'BG', 'NAME' => 'Bulgaria', 'PHONE_CODE' => '359' ),
				array( 'ISO_CODE' => 'BF', 'NAME' => 'Burkina Faso', 'PHONE_CODE' => '226' ),
				array( 'ISO_CODE' => 'BI', 'NAME' => 'Burundi', 'PHONE_CODE' => '257' ),
				array( 'ISO_CODE' => 'KH', 'NAME' => 'Cambodia', 'PHONE_CODE' => '855' ),
				array( 'ISO_CODE' => 'CM', 'NAME' => 'Cameroon', 'PHONE_CODE' => '237' ),
				array( 'ISO_CODE' => 'CA', 'NAME' => 'Canada', 'PHONE_CODE' => '1' ),
				array( 'ISO_CODE' => 'CV', 'NAME' => 'Cape Verde', 'PHONE_CODE' => '238' ),
				array( 'ISO_CODE' => 'KY', 'NAME' => 'Cayman Islands', 'PHONE_CODE' => '1 345' ),
				array( 'ISO_CODE' => 'CF', 'NAME' => 'Central African Republic', 'PHONE_CODE' => '236' ),
				array( 'ISO_CODE' => 'TD', 'NAME' => 'Chad', 'PHONE_CODE' => '235' ),
				array( 'ISO_CODE' => 'CL', 'NAME' => 'Chile', 'PHONE_CODE' => '56' ),
				array( 'ISO_CODE' => 'CN', 'NAME' => 'China', 'PHONE_CODE' => '86' ),
				array( 'ISO_CODE' => 'CX', 'NAME' => 'Christmas Island', 'PHONE_CODE' => '61' ),
				array( 'ISO_CODE' => 'CC', 'NAME' => 'Cocos (Keeling) Islands', 'PHONE_CODE' => '61' ),
				array( 'ISO_CODE' => 'CO', 'NAME' => 'Colombia', 'PHONE_CODE' => '57' ),
				array( 'ISO_CODE' => 'KM', 'NAME' => 'Comoros', 'PHONE_CODE' => '269' ),
				array( 'ISO_CODE' => 'CD', 'NAME' => 'Democratic Republic of the Congo', 'PHONE_CODE' => '243' ),
				array( 'ISO_CODE' => 'CG', 'NAME' => 'Republic of Congo', 'PHONE_CODE' => '242' ),
				array( 'ISO_CODE' => 'CK', 'NAME' => 'Cook Islands', 'PHONE_CODE' => '682' ),
				array( 'ISO_CODE' => 'CR', 'NAME' => 'Costa Rica', 'PHONE_CODE' => '506' ),
				array( 'ISO_CODE' => 'HR', 'NAME' => 'Croatia (Hrvatska)', 'PHONE_CODE' => '385' ),
				array( 'ISO_CODE' => 'CU', 'NAME' => 'Cuba', 'PHONE_CODE' => '53' ),
				array( 'ISO_CODE' => 'CY', 'NAME' => 'Cyprus', 'PHONE_CODE' => '357' ),
				array( 'ISO_CODE' => 'CZ', 'NAME' => 'Czech Republic', 'PHONE_CODE' => '420' ),
				array( 'ISO_CODE' => 'DK', 'NAME' => 'Denmark', 'PHONE_CODE' => '45' ),
				array( 'ISO_CODE' => 'DJ', 'NAME' => 'Djibouti', 'PHONE_CODE' => '253' ),
				array( 'ISO_CODE' => 'DM', 'NAME' => 'Dominica', 'PHONE_CODE' => '1 767' ),
				array( 'ISO_CODE' => 'DO', 'NAME' => 'Dominican Republic', 'PHONE_CODE' => '1 809' ),
				array( 'ISO_CODE' => 'TP', 'NAME' => 'East Timor', 'PHONE_CODE' => '670' ),
				array( 'ISO_CODE' => 'EC', 'NAME' => 'Ecuador', 'PHONE_CODE' => '593' ),
				array( 'ISO_CODE' => 'EG', 'NAME' => 'Egypt', 'PHONE_CODE' => '20' ),
				array( 'ISO_CODE' => 'SV', 'NAME' => 'El Salvador', 'PHONE_CODE' => '503' ),
				array( 'ISO_CODE' => 'GQ', 'NAME' => 'Equatorial Guinea', 'PHONE_CODE' => '240' ),
				array( 'ISO_CODE' => 'ER', 'NAME' => 'Eritrea', 'PHONE_CODE' => '291' ),
				array( 'ISO_CODE' => 'EE', 'NAME' => 'Estonia', 'PHONE_CODE' => '372' ),
				array( 'ISO_CODE' => 'ET', 'NAME' => 'Ethiopia', 'PHONE_CODE' => '251' ),
				array( 'ISO_CODE' => 'FK', 'NAME' => 'Falkland Islands (Malvinas)', 'PHONE_CODE' => '500' ),
				array( 'ISO_CODE' => 'FO', 'NAME' => 'Faroe Islands', 'PHONE_CODE' => '298' ),
				array( 'ISO_CODE' => 'FJ', 'NAME' => 'Fiji', 'PHONE_CODE' => '679' ),
				array( 'ISO_CODE' => 'FI', 'NAME' => 'Finland', 'PHONE_CODE' => '358' ),
				array( 'ISO_CODE' => 'FR', 'NAME' => 'France', 'PHONE_CODE' => '33' ),
				array( 'ISO_CODE' => 'PF', 'NAME' => 'French Polynesia', 'PHONE_CODE' => '689' ),
				array( 'ISO_CODE' => 'GA', 'NAME' => 'Gabon', 'PHONE_CODE' => '241' ),
				array( 'ISO_CODE' => 'GM', 'NAME' => 'Gambia', 'PHONE_CODE' => '220' ),
				array( 'ISO_CODE' => 'GE', 'NAME' => 'Georgia', 'PHONE_CODE' => '995' ),
				array( 'ISO_CODE' => 'DE', 'NAME' => 'Germany', 'PHONE_CODE' => '49' ),
				array( 'ISO_CODE' => 'GH', 'NAME' => 'Ghana', 'PHONE_CODE' => '233' ),
				array( 'ISO_CODE' => 'GI', 'NAME' => 'Gibraltar', 'PHONE_CODE' => '350' ),
				array( 'ISO_CODE' => 'GR', 'NAME' => 'Greece', 'PHONE_CODE' => '30' ),
				array( 'ISO_CODE' => 'GL', 'NAME' => 'Greenland', 'PHONE_CODE' => '299' ),
				array( 'ISO_CODE' => 'GD', 'NAME' => 'Grenada', 'PHONE_CODE' => '1 473' ),
				array( 'ISO_CODE' => 'GU', 'NAME' => 'Guam', 'PHONE_CODE' => '1 671' ),
				array( 'ISO_CODE' => 'GT', 'NAME' => 'Guatemala', 'PHONE_CODE' => '502' ),
				array( 'ISO_CODE' => 'GN', 'NAME' => 'Guinea', 'PHONE_CODE' => '224' ),
				array( 'ISO_CODE' => 'GW', 'NAME' => 'Guinea-Bissau', 'PHONE_CODE' => '245' ),
				array( 'ISO_CODE' => 'GY', 'NAME' => 'Guyana', 'PHONE_CODE' => '592' ),
				array( 'ISO_CODE' => 'HT', 'NAME' => 'Haiti', 'PHONE_CODE' => '509' ),
				array( 'ISO_CODE' => 'HN', 'NAME' => 'Honduras', 'PHONE_CODE' => '504' ),
				array( 'ISO_CODE' => 'HK', 'NAME' => 'Hong Kong', 'PHONE_CODE' => '852' ),
				array( 'ISO_CODE' => 'HU', 'NAME' => 'Hungary', 'PHONE_CODE' => '36' ),
				array( 'ISO_CODE' => 'IS', 'NAME' => 'Iceland', 'PHONE_CODE' => '354' )
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists( 'TM_COUNTRY' );
	}
}
