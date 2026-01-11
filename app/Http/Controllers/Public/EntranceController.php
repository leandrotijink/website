<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Controllers\Public;

use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class EntranceController extends Controller
{
	public function index(): View|RedirectResponse
	{
		Cache::flush();
		return view('public.index');
	}
}