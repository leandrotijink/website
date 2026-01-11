<?php

use App\Http\Middleware\ConfiguresHeaders;
use App\Http\Middleware\ConfiguresLanguage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		health: '/up',
		then: function () {
			Route::middleware(['web', 'auth.session'])->group(function () {
				Route::name('public.')->group(base_path('routes/public.php'));
			});
		}
	)
	->withMiddleware(function (Middleware $middleware): void {
		$middleware->redirectGuestsTo(fn(Request $request) => route('auth.login.start'));
		$middleware->redirectUsersTo(fn(Request $request) => route('public.homepage'));
		$middleware->appendToGroup('web', [
			ConfiguresHeaders::class,
			ConfiguresLanguage::class,
		]);
	})
	->withExceptions(function (Exceptions $exceptions): void {
		$exceptions->render(function (NotFoundHttpException $exception, Request $request) {
			if ($exception->getPrevious() instanceof ModelNotFoundException) {
				if ($request->expectsJson()) {
					return response()->json([
						'message' => 'The requested resource could not be located.'
					], 404);
				}
				return response(status: 404);
			}
		});
	})->create();