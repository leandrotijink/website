<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ListCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
	{
		if (is_null($value) || $value === '') {
			return [];
		}

        return array_map('trim', explode(',', $value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
	{
		return implode(', ', array_filter($value));
    }
}