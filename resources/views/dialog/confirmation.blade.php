<x-overlay.minimal>
	<main class="flex flex-col gap-4">
		<div class="card flex flex-col justify-center items-center gap-4 px-5 py-8">
			<span class="text-red-500 dark:text-red-400 *:size-14 mb-2">{!! icon('symbols.alert-circle') !!}</span>

			<h1 class="font-bold text-2xl">{{ __($title ?? 'Are you sure?') }}</h1>

			<p class="font-medium opacity-65">{{ __($message ?? 'Are you sure you want to perform this action?') }}</p>
		</div>
	</main>
	<aside class="grid grid-cols-2 gap-4 *:py-2.5 *:rounded-xl sticky bottom-0 pt-4 pb-5 bg-neutral-100 dark:bg-neutral-950">
		@if (isset($return))
			<a href="{{ $return }}" class="button outlined">{{ __('Cancel') }}</a>
		@else
			<a href="#" data-message="overlay:close" class="button outlined">{{ __('Cancel') }}</a>
		@endif
		<x-embla::button class="button danger">{{ __('Confirm') }}</x-embla::button>
	</aside>
</x-overlay.minimal>