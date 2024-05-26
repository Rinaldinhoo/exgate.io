
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Afiliados</title>

		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/responsive.dataTables.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">
		<style>
			.info-box {
				background-color: white;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				text-align: center;
				margin-bottom: 20px;
			}
			.info-title {
				font-weight: bold;
			}
			.info-value {
				margin-top: 10px;
				font-size: 1.2em;
				color: #007bff;
			}
		</style>
	</head>


	<body class="font-montserrat">

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<!-- Jquery Core Js -->

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			function copiarLink() {
				var copyText = document.getElementById("linkDivulgacao");
				var range = document.createRange();
				range.selectNode(copyText);
				window.getSelection().removeAllRanges();
				window.getSelection().addRange(range);
				try {
					var successful = document.execCommand('copy');
					var msg = successful ? 'Link copiado: ' : 'Erro ao copiar o link: ';
					alert(msg + copyText.innerText);
				} catch (err) {
					alert('Erro ao copiar o link: ' + err);
				}
				window.getSelection().removeAllRanges();
			}
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				window.addEventListener('swal:modal', event => {
					$('#modalAutenticacao').modal('hide');
					Swal.fire({
						icon: event.detail.type,
						title: event.detail.title,
						text: event.detail.text,
						confirmButtonText: 'Fechar'
					}).then((result) => {
						// Redireciona para a tela inicial
						 window.location.href = '/wallet';
					});
				});
			});
		</script>

	</body>

</html>


