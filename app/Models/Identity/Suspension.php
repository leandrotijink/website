<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suspension extends Model
{
	protected $table = 'user_suspensions';

	protected $casts = [
		'expires_at' => 'datetime',
	];

	// -----------------
	// Relationships

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}