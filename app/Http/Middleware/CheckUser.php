<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (isAdmin()) {
			return $next($request);
		} else {
			return redirect()->route('dashboardPage');
		}

	}
}
