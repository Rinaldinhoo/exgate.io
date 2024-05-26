
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Carteira </title>

		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/css/cryptoon.style.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/responsive.dataTables.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/Html/dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">
		<style>
			.table-responsive {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}
	
		@media screen and (max-width: 768px) {
			table {
				/* Reduz o tamanho da fonte para dispositivos menores */
				font-size: 14px;
			}
			th, td {
				/* Adiciona mais espaço de padding para cada célula em dispositivos menores */
				padding: 10px;
			}
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

		<script src="{{ asset('template/Html/dist/assets/bundles/dataTables.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/apexcharts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>

		<script src="{{ asset('template/Html/js/page/wallet.js?v=4') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			function copyCode() {
				var copyText = document.getElementById("copycode").innerText; // Pega o texto do elemento span
				navigator.clipboard.writeText(copyText).then(function() {
					console.log('Texto copiado com sucesso!');
					alert('Carteira copiada com sucesso!'); // Notificação ao usuário
				}).catch(function(error) {
					console.error('Erro ao copiar texto: ', error);
					alert('Erro ao copiar texto, tente novamente.');
				});
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

		<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecionar todos os itens do dropdown
        var dropdownItems = document.querySelectorAll('.dropdown-item');

        // Adicionar um ouvinte de eventos a cada item
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function() {
                // Pegar o valor do atributo data-value do item clicado
                var value = this.getAttribute('data-value');
				if (value == "BTC") {
					document.querySelectorAll('.isBTC').forEach(function(el) {
						el.style.display = "block";
						Livewire.emit('updatecoin', 'BTC');
					});
					document.querySelectorAll('.isUSD').forEach(function(el) {
						el.style.display = "none";
					});
					document.querySelectorAll('.isBRL').forEach(function(el) {
						el.style.display = "none";
					});
				} else if (value == "BRL") {
					document.querySelectorAll('.isBRL').forEach(function(el) {
						el.style.display = "block";
						Livewire.emit('updatecoin', 'BRL');
					});
					document.querySelectorAll('.isUSD').forEach(function(el) {
						el.style.display = "none";
					});
					document.querySelectorAll('.isBTC').forEach(function(el) {
						el.style.display = "none";
					});
				} else {
					document.querySelectorAll('.isUSD').forEach(function(el) {
						el.style.display = "block";
						Livewire.emit('updatecoin', 'USDT');
					});
					document.querySelectorAll('.isBRL').forEach(function(el) {
						el.style.display = "none";
					});
					document.querySelectorAll('.isBTC').forEach(function(el) {
						el.style.display = "none";
					});
				}

                // Atualizar o texto do botão com o valor selecionado
                document.getElementById('dropdownMenuButton').textContent = value;
            });
        });
    });
</script>



	</body>

</html>


