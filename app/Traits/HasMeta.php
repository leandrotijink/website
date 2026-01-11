<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Traits;

trait HasMeta
{

	public function hasMeta(string $name): bool
	{
		return $this->getMetaValue($name) !== null;
	}

	public function getMeta(string $name): mixed
	{
		return $this->meta->first(function ($meta) use ($name) {
			return $meta->name === $name;
		});
	}

	public function getMetaValue(string $name, mixed $default = null): mixed
	{
		return $this->getMeta($name)?->value ?? $default;
	}

}