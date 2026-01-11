<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class ConfiguresHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		$response = $next($request);

		$response->header('Referrer-Policy', 'same-origin');
		$response->header('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
		$response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), usb=(), interest-cohort=(), payment=()');

		if (App::environment('local')) {
			$response->header('Content-Security-Policy', "default-src 'self' data: * 'unsafe-inline';");
		} else {
			$response->header('Content-Security-Policy', "default-src 'self' data: https://leandrotijink.com https://challenges.cloudflare.com https://static.cloudflareinsights.com https://leandrotijink.ams3.cdn.digitaloceanspaces.com https://api.qrserver.com; frame-src https://challenges.cloudflare.com https://*.youtube.com https://youtube.com 'self'");
		}

        return $response;
    }
}