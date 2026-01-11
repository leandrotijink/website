<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Http\Controllers\Public;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class EntranceController extends Controller
{
	public function index(): View|RedirectResponse
	{
		return view('public.index');
	}
}