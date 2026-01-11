<x-public.layout highlight="home">
	<x-slot:meta>
		<meta name="description" content="{{ __(config('registry.about.description')) }}">
		<meta name="keywords" content="{{ config('registry.about.keywords') }}">

		<meta property="og:type" content="website">
		<meta property="og:title" content="{{ config('registry.about.name') }}">
		<meta property="og:description" content="{{ __(config('registry.about.description')) }}">
		<meta property="og:image" content="{{ config('registry.about.logo') }}">

		<meta name="twitter:title" content="{{ config('registry.about.name') }}">
		<meta name="twitter:description" content="{{ __(config('registry.about.description')) }}">
		<meta name="twitter:image" content="{{ config('registry.about.logo') }}">
	</x-slot:meta>

	<div class="w-xl max-w-fit mx-auto mt-10 py-5 px-10 rounded-xl text-center bg-emerald-400/30 border border-emerald-400">
		<p>My website is temporarily offline.</p>
	</div>

</x-public.layout>