<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Beste {{ $receiver->nickname }},</h1>

		<p>Het wachtwoord van je account is gewijzigd. Heb jij dit gedaan? Dan kun je deze e-mail negeren en verwijderen.</p>

		<p>Heb je het wachtwoord niet gewijzigd? Dan betekent het dat iemand anders heeft ingelogd met het vorige wachtwoord, en vervolgens het wachtwoord heeft gewijzigd. Je kan weer toegang krijgen door <a href="{{ route('auth.recovery.start') }}">Account Herstel</a> te gebruiken.</p>

		<br>

		<div class="boxed">
			Vergeet niet om nooit hetzelfde wachtwoord te gebruiken voor meerdere websites en diensten. Dit is essentieel om je accounts veilig te houden.
		</div>
	</div>
</x-mailable.skeleton>