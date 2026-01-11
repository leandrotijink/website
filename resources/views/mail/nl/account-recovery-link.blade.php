<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Beste {{ $receiver->nickname }},</h1>

		<p>Er is een verzoek ingediend om het wachtwoord van jouw account te wijzigen. Als jij dit was, kun je de onderstaande link openen en de stappen volgen. Deze link verloopt na 30 minuten.</p>

		<hr>

		<p><a class="button" href="{{ $url }}">Verander je wachtwoord</a></p>

		<br>

		<div class="boxed">
			Als jij dit niet was, kunt je deze e-mail gerust negeren en verwijderen. Er zullen geen wijzigingen aan jouw wachtwoord worden aangebracht.
		</div>
	</div>
</x-mailable.skeleton>