<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
	protected $table = 'user_tokens';

	protected $casts = [
		'is_used' => 'boolean',
		'expires_at' => 'datetime',
	];

	protected $fillable = [
		'client',
		'hash',
		'expires_at',
	];

	protected $with = [
		'user'
	];

	// -----------------

	public function getRouteKeyName(): string
	{
		return 'hash';
	}

	// -----------------
	// Relationships

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}