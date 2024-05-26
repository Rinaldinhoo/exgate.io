
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Exchange</title>

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

		<script  src="https://s3.tradingview.com/tv.js"></script>

		<script src="{{ asset('template/Html/js/template.js?v=1') }}"></script>

		<script src="{{ asset('template/Html/js/page/trocas.js?v=5') }}"></script>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var amountBuyInput = document.getElementById('amountbuy');
				var totalbuyInput = document.getElementById('totalbuy');
				var amountSellInput = document.getElementById('amountsell');
				var totalsellInput = document.getElementById('totalsell');
				var controleLimitBuy = document.getElementById('controleLimitBuy');
    			var controleLimitSell = document.getElementById('controleLimitSell');

				amountBuyInput.addEventListener('input', calcularAmountTotalBuy);
				totalbuyInput.addEventListener('input', calcularTotalBuy);
				amountSellInput.addEventListener('input', calcularAmountTotalSell);
				totalsellInput.addEventListener('input', calcularTotalSell);
				controleLimitBuy.addEventListener('input', function(event) {
					var posicao = parseInt(controleLimitBuy.value);
					let usdt = document.getElementById('amtusdt').value;
					let porcentagem = 0;
					switch (posicao) {
						case 1:
							porcentagem = 0; // 0%
							break;
						case 2:
							porcentagem = 0.25; // 25%
							break;
						case 3:
							porcentagem = 0.50; // 50%
							break;
						case 4:
							porcentagem = 0.75; // 75%
							break;
						case 5:
							porcentagem = 1.00; // 100%
							break;
						default:
							console.log("Posição inválida");
							break;
					}

					document.getElementById('totalbuy').value = (usdt * porcentagem);
					document.getElementById('totalbuy').dispatchEvent(new Event('input'));

				});
			controleLimitSell.addEventListener('input', function(event) {
				var posicao = parseInt(controleLimitSell.value);
				let btc = document.getElementById('amtbrl').value;
				let porcentagem = 0;

				switch (posicao) {
					case 1:
						porcentagem = 0; // 0%
						break;
					case 2:
						porcentagem = 0.25; // 25%
						break;
					case 3:
						porcentagem = 0.50; // 50%
						break;
					case 4:
						porcentagem = 0.75; // 75%
						break;
					case 5:
						porcentagem = 1.00; // 100%
						break;
					default:
						console.log("Posição inválida");
						break;
				}

				document.getElementById('amountsell').value = (btc * porcentagem);
				document.getElementById('amountsell').dispatchEvent(new Event('input'));
			});

				function calcularAmountTotalBuy() {
					let totalbuy = document.getElementById('amountbuy').value.replace(',', '.');
					if (totalbuy) {
						let novoValor = (totalbuy / document.getElementById('pricenow').value).toFixed(2);
						Livewire.emit('atualizarAmountBuy', novoValor);
						document.getElementById("totalbuy").value = novoValor;
					}
				}

				function calcularTotalBuy() {
					let totalbuy = document.getElementById('totalbuy').value.replace(',', '.');
					if (totalbuy) {
						let novoValor = (totalbuy * document.getElementById('pricenow').value).toFixed(2);
						document.getElementById("amountbuy").value = novoValor;
						Livewire.emit('atualizarAmountBuy', totalbuy);
					}
				}

				function calcularAmountTotalSell() {
					let totalsell = document.getElementById('amountsell').value.replace(',', '.');
					if (totalsell) {
						let novoValor = (totalsell / document.getElementById('pricenow').value).toFixed(2);
						Livewire.emit('atualizarAmountSell', totalsell);
						document.getElementById("totalsell").value = novoValor;
					}
				}

				function calcularTotalSell() {
					let totalsell = document.getElementById('totalsell').value.replace(',', '.');
					if (totalsell) {
						let novoValor = (totalsell * document.getElementById('pricenow').value).toFixed(2);
						document.getElementById("amountsell").value = novoValor;
						Livewire.emit('atualizarAmountSell', novoValor);
					}
				}

				window.addEventListener('resetarCampos', function() {
					document.getElementById('amountsell').value = null;
					document.getElementById('totalsell').value = null;
					document.getElementById('amountbuy').value = null;
					document.getElementById('totalbuy').value = null;
				});
			});

		</script>
	</body>

</html>


