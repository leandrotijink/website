<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Identity;

use App\Traits\HasMeta;
use DateTimeInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract, HasLocalePreference
{
	use Authenticatable, Authorizable, HasMeta, HasRoles;

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'active_at' => 'datetime',
	];

	protected $fillable = [
		'username',
		'nickname',
		'email',
		'password',
		'locale_id',
		'active_at',
	];

    protected $hidden = [
        'password',
        'remember_token',
    ];

	protected $with = [
		'meta'
	];

	// -----------------
	// Properties

	public string $avatar_url {
		get {
			if (isset($this->id)) {
				$meta = $this->meta->first(function ($meta) {
					return $meta->name === 'avatar';
				});

				if ($meta !== null) {
					return Storage::url('avatars/' . md5($this->id) . '/' . $meta->value);
				}
			}
			return Storage::url('avatars/default.svg');
		}
	}

	public function activeAt(): Attribute
	{
		return Attribute::make(
			get: fn (string|null $value) => $value ? now()->parse($value) : $this->created_at,
			set: fn (mixed $value) => $value instanceof DateTimeInterface ? $value->format('Y-m-d H:i:s') : $value,
		);
	}

	// -----------------

	public function isOnline(int $minutes = 5): bool
	{
		return $this->active_at->diffInMinutes() <= $minutes;
	}

	public function isActive(int $days = 365): bool
	{
		return $this->active_at->diffInDays() <= $days;
	}

	public function preferredLocale(): string|null
	{
		return $this->locale_id;
	}

	// -----------------
	// Relationships

	public function meta(): HasMany
	{
		return $this->hasMany(Meta::class);
	}

	public function suspensions(): HasMany
	{
		return $this->hasMany(Suspension::class);
	}

	public function tokens(): HasMany
	{
		return $this->hasMany(Token::class);
	}

	public function guards(): HasMany
	{
		return $this->hasMany(TwoFactorMethod::class);
	}

	public function activity(): HasMany
	{
		return $this->hasMany(Activity::class);
	}

}