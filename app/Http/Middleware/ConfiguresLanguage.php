<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\Response;

class ConfiguresLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		// Retrieve the locale from the user if specified.
		if (Auth::check() && Auth::user()->locale_id !== null) {
			app()->setLocale(Auth::user()->locale_id);
			Number::useLocale(Auth::user()->locale_id);
			return $next($request);
		}

		// Retrieve the locale from the session if available.
		if (Session::has('locale')) {
			app()->setLocale(Session::get('locale'));
			Number::useLocale(Session::get('locale'));
			return $next($request);
		}

		Number::useLocale(app()->getLocale());

        return $next($request);
    }
}