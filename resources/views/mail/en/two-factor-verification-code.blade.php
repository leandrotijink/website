<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Hi {{ $receiver->nickname }},</h1>

		<p>We have detected a login attempt using valid credentials for your account. If this was you, please use the 6-digit code below to verify your identity.</p>

		<h2>{{ $code }}</h2>

		<br>

		<div class="boxed">
			Do not share verification codes like these with someone else. If you don't recognize this login, please change your password immediately.
		</div>
	</div>
</x-mailable.skeleton>