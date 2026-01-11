<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Services;

use App\Features\Security\OneTimePassword;
use App\GuardType;
use App\Mail\TwoFactorVerificationCode;
use App\Models\Identity\TwoFactorMethod;
use App\Models\Identity\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Throwable;

class TwoFactorService
{
	protected TwoFactorMethod $method;

	protected User $user;

	public function __construct()
	{
		if (auth()->check()) {
			$this->user = auth()->user();
		}
	}

	// -----------------

	public function for(User $user): self
	{
		$this->user = $user;
		return $this;
	}

	public function using(TwoFactorMethod $method): self
	{
		$this->method = $method;
		return $this;
	}

	// -----------------

	public function requiresFreshVerification(): bool
	{
		$verified_at = Session::get('guard_verification_time');

		if ($verified_at === null || new Carbon($verified_at)->addMinutes(5)->isPast()) {
			Session::put('guard_verification_return_route', request()->route()->getName());
			return true;
		}

		return false;
	}

	public function getNewRecoveryCodes(int $amount = 6): string
	{
		$codes = [];
		while (count($codes) < $amount) {
			$codes[] = $this->getRandomNumber(12);
		}

		return implode(',', $codes);
	}

	// -----------------

	public function prepare(): bool
	{
		return match ($this->method->type) {
			GuardType::Email => $this->prepareEmail(),
			default => true,
		};
	}

	public function verify(mixed $input): bool
	{
		return match ($this->method->type) {
			GuardType::App => $this->verifyApp($input),
			GuardType::Recovery => $this->verifyRecovery($input),
			GuardType::Email => $this->verifyEmail($input),
			default => false,
		};
	}

	// -----------------

	protected function prepareEmail(): bool
	{
		$timestamp = Session::get('guard_mail_timestamp');

		if ($timestamp instanceof Carbon === false || $timestamp->diffInMinutes() > 5) {

			$code = self::getRandomNumber(6);

			Session::put('guard_mail_code', $code);
			Session::put('guard_mail_timestamp', now());

			$mailable = new TwoFactorVerificationCode($this->user, $code);

			Mail::to($this->user)->send($mailable);

			return true;
		}

		return false;
	}

	// -----------------

	protected function verifyApp(string $input): bool
	{
		return OneTimePassword::from($this->method->content ?? '')->verify($input);
	}

	protected function verifyEmail(string $input): bool
	{
		$reference = Session::get('guard_mail_code');

		if ($reference === $input) {
			Session::remove('guard_mail_code');
			Session::remove('guard_mail_timestamp');
			return true;
		}

		return false;
	}

	protected function verifyRecovery(string $input): bool
	{
		$codes = explode(',', $this->method->content ?? '');

		foreach ($codes as $key => $value) {
			if ($value === $input) {
				unset($codes[$key]);
				$this->method->content = implode(',', $codes);
				return $this->method->save();
			}
		}

		return false;
	}

	// -----------------

	protected function getRandomNumber(int $length): string
	{
		$iteration = 0;
		$code = '';
		while ($iteration < $length) {
			try {
				$code .= random_int(0, 9);
			} catch (Throwable) { }
			$iteration++;
		}

		return strlen($code) < $length ? '458676' : $code;
	}

}