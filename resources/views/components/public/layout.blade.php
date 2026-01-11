<x-skeleton class="bg-neutral-100 dark:bg-neutral-950 print:bg-white">
	<x-slot:title>
		{{ isset($title) ? $title . ' - ' : '' }}{{ config('registry.about.name') }}
	</x-slot:title>

	<x-slot:meta>
		@can('access_dashboard')
			<meta name="theme-color" content="#0A0A0A" media="(prefers-color-scheme: light)">
			<meta name="theme-color" content="#0A0A0A" media="(prefers-color-scheme: dark)">
		@else
			<meta name="theme-color" content="#FFFFFF" media="(prefers-color-scheme: light)">
			<meta name="theme-color" content="#0A0A0A" media="(prefers-color-scheme: dark)">
		@endcan

		@isset($meta)
			{{ $meta }}
		@endif
	</x-slot:meta>

	<x-public.layout.header/>

	{{ $slot }}

	<x-public.layout.footer/>

	@isset($attributes['highlight'])
		<trigger data-type="highlight" data-item="{{ $attributes['highlight'] }}" data-prefix=".nav-" data-class="selected"></trigger>
	@endisset

</x-skeleton>