<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Beste {{ $receiver->nickname }},</h1>

		<p>We hebben een inlog-poging gedetecteerd welke gebruik maakt van correcte inloggegevens. Als jij dit bent, gebruik je de 6-cijferige code hieronder om je identiteit te verifiëren.</p>

		<h2>{{ $code }}</h2>

		<br>

		<div class="boxed">
			Deel verificatiecodes zoals hierboven niet met anderen. Als je deze login niet herkent, verander dan meteen je wachtwoord.
		</div>
	</div>
</x-mailable.skeleton>