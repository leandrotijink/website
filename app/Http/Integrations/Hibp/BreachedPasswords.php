<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Hibp;

use App\Http\Integrations\Hibp\Connectors\PasswordsConnector;
use App\Http\Integrations\Hibp\Requests\GetRangeRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Saloon\Http\Connector;
use Throwable;

/**
 * This integration is made possible by CBS OpenData.
 */
class BreachedPasswords
{
	protected Connector $connector;

	protected array $results = [];

	// -----------------

	public function __construct()
	{
		$this->connector = new PasswordsConnector();
	}

	// -----------------

	/**
	 * Provide the SHA1 hash of the password you wish to check.
	 */
	public function has(string $hash): bool
	{
		return $this->appearances($hash) > 0;
	}

	/**
	 * Provide the SHA1 hash of the password you wish to check.
	 */
	public function appearances(string $hash): int
	{
		$hash = strtoupper($hash);
		$entries = $this->getResultsForHash($hash);

		if (array_key_exists($hash, $entries)) {
			return $entries[$hash];
		}

		return 0;
	}

	// -----------------

	public function getResultsForHash(string $hash): array
	{
		return $this->getResultsForPrefix(Str::limit(strtoupper($hash), 5, ''));
	}

	protected function getResultsForPrefix(string $prefix): array
	{
		if (array_key_exists($prefix, $this->results)) {
			return $this->results[$prefix];
		}

		$response = $this->retrieveResult($prefix);

		$entries = [];

		if ($response !== null) {
			foreach (preg_split("/((\r?\n)|(\r\n?))/", $response) as $line) {
				[$suffix, $count] = explode(':', $line);
				if ((int)$count > 0) {
					$entries[$prefix . $suffix] = (int)$count;
				}
			}
		}

		$this->results[$prefix] = $entries;

		return $entries;
	}

	protected function retrieveResult(string $prefix): string|null
	{
		$request = new GetRangeRequest($prefix);
		$result = null;

		try {
			$response = $this->connector->send($request);
			if ($response->successful()) {
				$result = $response->body();
			} else {
				Log::notice('There was a problem with reaching the Passwords API', [$response->body()]);
			}
		} catch (Throwable $throwable) {
			Log::notice('There was a problem processing the Passwords API response.', [$throwable->getMessage()]);
		}

		return $result;
	}
}