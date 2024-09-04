
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
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
   
		<style>
			#pixCode {
				word-wrap: break-word;
				overflow-wrap: break-word;
				max-width: 100%;
				white-space: pre-wrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}
			.table-responsive {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}
			.icon-large {
				font-size: 7rem;
				color: green;
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

		.hidden {
			display: none;
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

		<script src="{{ asset('qrcode.min.js?v=1') }}"></script>

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

			function copyPixCode() {
				var copyText = document.getElementById("pixCode").innerText; // Pega o texto do elemento span
				navigator.clipboard.writeText(copyText).then(function() {
					console.log('Texto copiado com sucesso!');
					document.getElementById('msgCode').classList.remove('d-none');

				}).catch(function(error) {
					console.error('Erro ao copiar texto: ', error);
					alert('Erro ao copiar texto, tente novamente.');
				});
			}
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				window.addEventListener('pix', event => {
					$(document).ready(function() {
						$('#modalQrcode').modal('show');

						var qrcode = new QRCode(document.getElementById("qrcode"), {
							text: event.detail.paymentCode,
							width: 256,
							height: 256,
							colorDark : "#000000",
							colorLight : "#ffffff",
							correctLevel : QRCode.CorrectLevel.L
						});
						$('#pixCode').html(event.detail.paymentCode)

						var transactionId = event.detail.idTransaction; // Assumindo que você tem um ID de transação

						var checkStatusInterval = setInterval(function() {
							$.ajax({
								url: '/api/suitpay/status',
								method: 'GET',
								data: { idTransaction: transactionId },
								success: function(response) {
									if (response.status === 'Concluido') {
										//$('#modalQrcode').modal('hide');
										$('#qrcode').addClass('d-none');
										$('#pixCode').addClass('d-none');
										$('#successIcon').removeClass('d-none');	
										clearInterval(checkStatusInterval);
									}
								},
								error: function(xhr, status, error) {
									console.error('Erro ao verificar o status da transação:', error);
								}
							});
						}, 5000);
					} );
				});
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


