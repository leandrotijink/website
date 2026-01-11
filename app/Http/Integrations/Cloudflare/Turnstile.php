<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Cloudflare;

use App\Http\Integrations\Cloudflare\Connectors\TurnstileConnector;
use App\Http\Integrations\Cloudflare\Requests\VerificationRequest;
use Illuminate\Support\Facades\Log;
use Saloon\Http\Connector;
use Throwable;

/**
 * This integration is made possible by CBS OpenData.
 */
class Turnstile
{
	protected Connector $connector;

	// -----------------

	public function __construct()
	{
		$this->connector = new TurnstileConnector();
	}

	// -----------------

	public function verify(string $token): bool
	{
		return $this->retrieveDataSet($token);
	}

	// -----------------

	protected function retrieveDataSet(string $token): bool
	{
		$request = new VerificationRequest($token);

		try {
			$response = $this->connector->send($request);
			if ($response->successful()) {
				return (bool) $response->json()['success'] ?? false;
			} else {
				Log::notice('There was a problem with reaching the Turnstile API', [$response->body()]);
			}
		} catch (Throwable $throwable) {
			Log::notice('There was a problem processing the Turnstile API response.', [$throwable->getMessage()]);
		}

		return false;
	}
}