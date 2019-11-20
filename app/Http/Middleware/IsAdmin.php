<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class IsAdmin {

	public function handle( $request, Closure $next ) {
		$session = session( 'LOGIN_DATA' );
		if ( $session['ROLE_ID'] == 2 ) {
			return abort( 404 );
		}
		return $next( $request );
	}

}