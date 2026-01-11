<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use App\ActivityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
	protected $table = 'user_activity';

	protected $casts = [
		'type' => ActivityType::class,
		'context' => 'array',
	];

	protected $fillable = [
		'type',
		'ip_address',
		'context',
	];

	// -----------------
	// Relationships

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}