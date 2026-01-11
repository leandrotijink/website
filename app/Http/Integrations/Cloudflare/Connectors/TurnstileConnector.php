<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Cloudflare\Connectors;

use Saloon\Http\Connector;

/**
 * This integration is made possible by HaveIBeenPwned.
 */
class TurnstileConnector extends Connector
{
	public function resolveBaseUrl(): string
	{
		return 'https://challenges.cloudflare.com/turnstile/v0';
	}

}