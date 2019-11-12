<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Installation extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'client-portal:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		print 'Project installation:'.PHP_EOL;

		// $cmd_chmod_777 = shell_exec( 'chmod -R 777 vendor/ storage/ bootstrap/ resources/ .env' );
		// print '-> Change mode folder permission vendor, storage, bootstrap, resources, and .env to 777 - OK'.PHP_EOL;
		
		// $check_db_connection = ( self::testing_db_connection_status() == true ? 'OK' : 'ERROR' );
		// print '-> Check database connection - '.$check_db_connection.PHP_EOL;
	}

	private function testing_db_connection_status() {
		try {
			DB::connection( DB::getDefaultConnection() )->reconnect();
			return true;
		}
		catch( \Exception $e ) {
			return false;
		}
	}
}
