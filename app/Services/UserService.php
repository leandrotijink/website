<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Services;

use App\Mail\PasswordChangedNotification;
use App\Models\Identity\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class UserService
{
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

	// -----------------

	public function setPassword(string $password): bool
	{
		$this->user->password = $password;

		if ($this->user->save()) {
			Mail::to($this->user)->send(new PasswordChangedNotification($this->user));

			$this->user->activity()->create([
				'ip_address' => request()->ip(),
				'type' => 'security_password_changed',
			]);
			return true;
		}

		return false;
	}

	public function setAvatar(UploadedFile|null $avatar): void
	{
		if ($avatar === null) {
			$this->user->meta()->where('name', 'avatar')->delete();
		} else {
			$avatar = Image::read($avatar);
			$avatar->scaleDown(200);
			$file = Str::random() . '.webp';

			if (Storage::put('avatars/' . md5($this->user->id) . '/' . $file, $avatar->toWebp(quality: 100))) {
				$this->user->meta()->updateOrCreate(['name' => 'avatar'], [
					'value' => $file
				]);
			}
		}
	}
}