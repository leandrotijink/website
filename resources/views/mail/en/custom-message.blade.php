@php use App\Markdown\Embla\EmblaExtension; @endphp
<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Hi {{ $receiver->nickname }},</h1>

		{!! Str::markdown($content, extensions: [new EmblaExtension()]) !!}

		<br>
		<p>Kind regards,<br/>{{ config('registry.about.name') }}<p>
	</div>
</x-mailable.skeleton>