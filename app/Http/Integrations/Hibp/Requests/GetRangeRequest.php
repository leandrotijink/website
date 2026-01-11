<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Hibp\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * This integration is made possible by HaveIBeenPwned.
 */
class GetRangeRequest extends Request
{
	protected Method $method = Method::GET;

	protected string $prefix;

	public function __construct(string $prefix)
	{
		$this->prefix = $prefix;
	}

	public function resolveEndpoint(): string
	{
		return '/range/' . $this->prefix;
	}

	protected function defaultHeaders(): array
	{
		return [
			'Add-Padding' => 'true',
		];
	}
}