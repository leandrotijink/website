<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Hi {{ $receiver->nickname }},</h1>

		<p>A request has been made to change the password of your account. If this was you, you can open the link below and follow the steps. This link expires after 30 minutes.</p>

		<hr>

		<p><a class="button" href="{{ $url }}">Change your password</a></p>

		<br>

		<div class="boxed">
			If this wasn't you, you can safely ignore and delete this email. No changes will be made to your password.
		</div>
	</div>
</x-mailable.skeleton>