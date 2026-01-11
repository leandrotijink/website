<x-skeleton class="bg-neutral-100 dark:bg-neutral-950">
	<x-slot:title>{{ __('Alert') }}</x-slot:title>

	<form method="post" class="mx-auto max-w-7xl px-5 pt-5">
		@csrf
		{{ $slot }}
	</form>

</x-skeleton>