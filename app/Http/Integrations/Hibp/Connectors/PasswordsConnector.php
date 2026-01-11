<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Hibp\Connectors;

use Saloon\Http\Connector;

/**
 * This integration is made possible by HaveIBeenPwned.
 */
class PasswordsConnector extends Connector
{
	public function resolveBaseUrl(): string
	{
		return 'https://api.pwnedpasswords.com';
	}

}