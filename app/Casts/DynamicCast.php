<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DynamicCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
		$type = $attributes['type'] ?? 'string';

		return match ($type) {
			'list' => array_map('trim', explode(',', $value)),
			'datetime' => Carbon::parse($value),
			'array', 'json' => json_decode($value, true),
			'boolean' => (bool) $value,
			'integer' => (int) $value,
			'float' => (float) $value,
			default => $value,
		};
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
		if (is_array($value) || is_object($value)) {
			return json_encode($value);
		}

        return $value;
    }
}