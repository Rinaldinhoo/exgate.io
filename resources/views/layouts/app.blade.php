
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Painel </title>

		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/responsive.dataTables.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">

	</head>


	<body class="font-montserrat">

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<!-- Jquery Core Js -->

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/dataTables.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/apexcharts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>

		<script src="{{ asset('template/Html/js/page/index.js?v=2') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				window.addEventListener('swal:modal', event => {
					$('#esqueciSenhaModal').modal('hide');
					Swal.fire({
						icon: event.detail.type,
						title: event.detail.title,
						text: event.detail.text,
						confirmButtonText: 'Fechar'
					}).then((result) => {
						// Redireciona para a tela inicial
						window.location.href = '/';
					});
				});
			});
		</script>



	</body>

</html>


