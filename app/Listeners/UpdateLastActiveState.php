<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Listeners;

use Auth;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Cache;

class UpdateLastActiveState
{
    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {
		$key = 'last_active_hit:' . $event->user->getAuthIdentifier();

		if (Cache::has($key) === false) {
			Cache::put($key, now(), 10);

			Auth::user()->touch('active_at');
		}
    }
}