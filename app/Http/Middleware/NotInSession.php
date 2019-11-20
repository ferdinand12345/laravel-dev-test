<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class NotInSession {

	public function handle( $request, Closure $next ) {
		if( session()->has( 'LOGIN_DATA' ) ) {
			return abort( 404 );
		}
		return $next( $request );
	}

}