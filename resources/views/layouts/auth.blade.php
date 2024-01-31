<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Coinnexc - Autenticação </title>

	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

	<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

	
</head>

	<body>

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js') }}"></script>

	</body>

</html>