<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Rules;

use App\Http\Integrations\Hibp\BreachedPasswords;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SecurePassword implements ValidationRule
{
	protected int $limit = 10;

	public function __construct(int $limit = 10)
	{
		$this->limit = $limit;
	}

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
		$service = new BreachedPasswords();

		if ($service->appearances(sha1($value)) > $this->limit) {
			$fail('This password is not safe to use, as it has been found in data breaches on the internet.');
		}
    }
}