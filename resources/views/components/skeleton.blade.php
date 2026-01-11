<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
	<title>{{ $title }}</title>

	<meta charset="utf-8">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="canonical" href="{{ request()->url() }}">
	<link rel="manifest" href="/manifest.json">
	<link rel="icon" href="/favicon.ico">
	<meta name="color-scheme" content="light dark">

	<meta name="twitter:site" content="@leandrotijink">
	<meta property="og:site_name" content="{{ config('registry.about.name') }}"/>
	<meta property="og:locale" content="{{ app()->currentLocale() }}"/>
	<meta property="og:url" content="{{ request()->url() }}"/>

	@isset($meta)
		{{ $meta }}
	@endif

	@livewireStyles(['nonce' => $nonce])
	@vite(['resources/styles/app.css'])

</head>
<body {{ $attributes }}>

	{{ $slot }}

	@session('toast')
		@if(is_string($value))
			<toast>{!! icon('symbols.alert-circle') !!}<span>{{ __($value) }}</span></toast>
		@else
			<toast class="{{ $value->type ?? '' }}">{!! icon($value->icon ?? 'symbols.alert-circle') !!}<span>{{ __($value->message) }}</span></toast>
		@endif
	@endsession

	@isset($trigger_overlay)
		<trigger data-type="overlay" data-message="overlay:{{ $trigger_overlay->action }}@isset($trigger_overlay->value):{{ $trigger_overlay->value }}@endisset"></trigger>
	@endisset

	@isset($trigger_parent)
		<trigger data-type="overlay" data-message="parent:{{ $trigger_parent->action }}@isset($trigger_parent->value):{{ $trigger_parent->value }}@endisset"></trigger>
	@endisset

	@vite(['resources/scripts/app.js'])
	@livewireScriptConfig(['nonce' => $nonce])
</body>
</html>