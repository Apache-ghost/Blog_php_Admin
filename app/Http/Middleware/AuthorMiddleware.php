<?php

namespace App\Http\Middleware;

use Closure;

class AuthorMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (isAuthor()) {
			return $next($request);
		} else {
			return redirect()->route('dashboard.dashboardPage');
		}
	}
}
