
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Segurança</title>

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

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			function copyCode() {
				var copyText = document.getElementById("copycode").innerText; // Pega o texto do elemento span
				navigator.clipboard.writeText(copyText).then(function() {
					console.log('Texto copiado com sucesso!');
					alert('Código copiado com sucesso!'); // Notificação ao usuário
				}).catch(function(error) {
					console.error('Erro ao copiar texto: ', error);
					alert('Erro ao copiar texto, tente novamente.');
				});
			}
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				window.addEventListener('swal:modal', event => {
					$('#editprofile').modal('hide');
					Swal.fire({
						icon: event.detail.type,
						title: event.detail.title,
						text: event.detail.text,
						confirmButtonText: 'Fechar'
					});
				});
			});
			$(document).ready(function() {
				$('#checkfa').click(function() {
					$.ajax({
						url: '/security/checkfa?codeCheck='+$('#codeCheck').val(),
						type: 'GET',
						success: function(response) {
							$('#EnableModal').modal('hide');
							Swal.fire({
								icon: 'success',
								title: 'Sucesso',
								text: 'Foi habilitado com sucesso 2FA',
								confirmButtonText: 'Fechar'
							}).then(function() {
								location.reload(); // Atualiza a página
							});
						},
						error: function(xhr) {
							$('#EnableModal').modal('hide');
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Por favor, verifique o código!',
								confirmButtonText: 'Fechar'
							});
						}
					});
				});

				$('#confirmarExclusaoBtn').click(function() {
					$.ajax({
						url: '/security/excludecheckfa',
						type: 'GET',
						success: function(response) {
							$('#confirmacaoExclusaoModal').modal('hide');
							Swal.fire({
								icon: 'success',
								title: 'Sucesso',
								text: 'Foi Removido com sucesso 2FA',
								confirmButtonText: 'Fechar'
							}).then(function() {
								location.reload(); // Atualiza a página
							});
						},
						error: function(xhr) {
							$('#confirmacaoExclusaoModal').modal('hide');
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Por favor, verifique com o suporte!',
								confirmButtonText: 'Fechar'
							});
						}
					});
				});

				$('#confirmarExclusaoAccBtn').click(function() {
					$.ajax({
						url: '/security/excludeaccount',
						type: 'GET',
						success: function(response) {
							$('#DeleteAccountModal').modal('hide');
							Swal.fire({
								icon: 'success',
								title: 'Sucesso',
								text: 'Excluido com Sucesso',
								confirmButtonText: 'Fechar'
							}).then(function() {
								window.location.href = '/';
							});
						},
						error: function(xhr) {
							$('#DeleteAccountModal').modal('hide');
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Por favor, verifique com o suporte!',
								confirmButtonText: 'Fechar'
							});
						}
					});
				});
   			});
		</script>
	</body>

</html>


