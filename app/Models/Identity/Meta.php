<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use App\Casts\DynamicCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meta extends Model
{
	protected $table = 'user_meta';

	protected $casts = [
		'value' => DynamicCast::class
	];

	protected $fillable = [
		'name',
		'value',
		'type',
	];

	// -----------------
	// Relationships

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}