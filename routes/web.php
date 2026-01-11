<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::fallback(function () {
	// TODO: Swap this with an actual 404 page.
	return response(status: 404);
});

Route::get('/set-preference/locale/{locale}', function (string $locale) {
	if (array_key_exists($locale, config('app.locales'))) {
		Session::put('locale', $locale);
		if (Auth::check()) {
			Auth::user()->update(['locale_id' => $locale]);
		}
	}
	return back();
});