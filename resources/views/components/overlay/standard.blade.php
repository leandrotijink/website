<x-skeleton class="bg-neutral-100 dark:bg-neutral-950">
	<x-slot:title>{{ $title }}</x-slot:title>

	<div class="mx-auto max-w-7xl px-5 flex justify-between gap-5 items-center py-5 pb-1 sticky top-0 z-10 bg-neutral-100 dark:bg-neutral-950">
		<h1 class="grow font-bold text-xl pl-2">{{ $title }}</h1>
		<div class="flex gap-2">
			@isset($actions)
				{{ $actions }}
			@endif
			<a href="#" data-message="overlay:close" class="hover:bg-neutral-200/80 dark:hover:bg-neutral-800 rounded-md p-1.5" title="{{ __('Close') }}">{!! icon('symbols.xmark') !!}</a>
		</div>
	</div>

	<div {{ $attributes->class('mx-auto max-w-7xl px-5 pt-2') }}>
		{{ $slot }}
	</div>

</x-skeleton>