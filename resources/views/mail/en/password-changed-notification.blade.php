<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Hi {{ $receiver->nickname }},</h1>

		<p>The password of your account has been changed. If this was you, you can safely ignore and delete this email.</p>

		<p>Did you not change your password? That means someone successfully signed in using your old password and changed it. You can get access back by using <a href="{{ route('auth.recovery.start') }}">Account Recovery</a>.</p>

		<br>

		<div class="boxed">
			Remember to never use the same password across multiple different websites and services. This is essential to keeping your accounts secure.
		</div>
	</div>
</x-mailable.skeleton>