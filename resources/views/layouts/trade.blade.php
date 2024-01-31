
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Trade</title>

		<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	

		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/responsive.dataTables.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">

	</head>

	<style>
		@keyframes flashGreen {
			0%   { background-color: green; }
			50%  { background-color: transparent; }
			100% { background-color: green; }
		}

		@keyframes flashRed {
			0%   { background-color: red; }
			50%  { background-color: transparent; }
			100% { background-color: red; }
		}

		.price-rise {
			animation: flashGreen 1s;
		}

		.price-fall {
			animation: flashRed 1s;
		}

	</style>


	<body>

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<!-- Jquery Core Js -->

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/dataTables.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/apexcharts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js') }}"></script>

		<script src="{{ asset('template/Html/js/trade.js') }}"></script>


	</body>

</html>


