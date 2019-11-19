<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckLogin {

	public function handle( $request, Closure $next ) {
		if( !session()->has( 'LOGIN_DATA' ) ) {
			return redirect( 'login' );
		}
		return $next( $request );
	}

}