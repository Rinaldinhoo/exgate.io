<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Exgate.IO - Autenticação </title>

	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

	<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

	
</head>

	<body class="font-montserrat">

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>

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
					});
				});
			});
		</script>

	</body>

</html>