<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Number::useCurrency('EUR');

		$this->registerPatterns();
		$this->registerMacros();
	}

	// -----------------

	protected function registerPatterns(): void
	{
		Route::pattern('id', '[0-9]+');
	}

	protected function registerMacros(): void
	{
		Carbon::macro('toRemote', function () {
			return $this->setTimezone(config('app.timezone'));
		});

		Carbon::macro('toLocal', function () {
			return $this->locale(app()->getLocale())->setTimezone(config('app.timezone_local'));
		});

		Carbon::macro('isDayOfMonth', function (int $day) {
			return (int)$this->format('d') === $day;
		});

		Request::macro('client', function (string|null $default = 'Unknown') {
			if ($this->headers->has('Sec-CH-UA')) {
				$names = array_reduce(explode(',', trim($this->headers->get('Sec-CH-UA'))),
					function ($carry, $element) {
						$brand = Str::remove('"', Str::beforeLast($element, ';'));
						$version = str_contains($element, ';v=') ? Str::afterLast($element, ';v=') : '';
						if (str_contains($element, 'Brand') === false && str_contains($element, 'Chromium') === false) {
							$carry[trim($brand)] = (int)Str::remove($version, '"');
						}
						return $carry;
					}, []
				);
				$client = array_key_first($names);
			}
			return $client ?? $default;
		});

		Request::macro('platform', function (string|null $default = 'Unknown') {
			return trim($this->headers->get('Sec-CH-UA-Platform', $default), '"');
		});
	}
}