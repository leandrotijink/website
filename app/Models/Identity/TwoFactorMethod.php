<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use App\GuardType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoFactorMethod extends Model
{
	protected $fillable = [
		'user_id',
		'type',
		'content',
		'is_preferred',
	];
	protected $table = 'user_guards';

	protected $casts = [
		'type' => GuardType::class,
		'is_encrypted' => 'boolean',
		'is_preferred' => 'boolean',
	];

	// -----------------
	// Relationships

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}