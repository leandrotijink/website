<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App;

enum ActivityType: string
{
	case SecurityPasswordChanged = 'security_password_changed';

	// -----------------

	public function label(): string
	{
		return match ($this) {
			ActivityType::SecurityPasswordChanged => 'Password changed',
		};
	}
}