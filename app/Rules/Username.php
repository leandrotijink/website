<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Username implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
		if (preg_match('/^[A-Za-z][A-Za-z0-9]*(?:[_\-][A-Za-z0-9]+)*$/i', (string) $value) !== 1) {
			$fail('This username is not valid.');
		}
    }
}