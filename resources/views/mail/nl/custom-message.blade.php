@php use App\Markdown\Embla\EmblaExtension; @endphp
<x-mailable.skeleton>
	<x-slot:summary>
		{{ __($summary) }}
	</x-slot:summary>

	<div>
		<h1>Beste {{ $receiver->nickname }},</h1>

		{!! Str::markdown($content, extensions: [new EmblaExtension()]) !!}

		<br>
		<p>Met vriendelijke groet,<br/>{{ config('registry.about.name') }}<p>
	</div>
</x-mailable.skeleton>