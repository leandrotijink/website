<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Integrations\Cloudflare\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * This integration is made possible by Cloudflare.
 */
class VerificationRequest extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;

	protected string $token;
	protected string $secret;

	public function __construct(string $token, string|null $secret = null)
	{
		$this->token = $token;
		$this->secret = $secret ?? config('app.turnstile.secret');
	}

	public function resolveEndpoint(): string
	{
		return '/siteverify';
	}

	protected function defaultBody(): array
	{
		return [
			'response' => $this->token,
			'secret' => $this->secret,
		];
	}
}