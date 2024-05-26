
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Exgate.IO - Futuros</title>

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


	<body class="font-montserrat">

		<main>
			{{$slot}}
		</main>

		@livewireScripts

		<!-- Jquery Core Js -->

		<script src="{{ asset('template/Html/dist/assets/bundles/libscripts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/dataTables.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/dist/assets/bundles/apexcharts.bundle.js') }}"></script>

		<script src="{{ asset('template/Html/js/template.js') }}"></script>

		<script src="{{ asset('template/Html/js/trade.js') }}?v={{ rand() }}"></script>

		<script>
			document.addEventListener('DOMContentLoaded', function () {
				window.addEventListener('rangevalue', event => {
					document.querySelector('input[type=range]').value = 1;
				});

				window.addEventListener('contentChanged', event => {
					atualizarDataTableteste('#ordertabone', '#OpenOrder', '#OpenOrder');
					// setTimeout(() => {
					// 	atualizarDataTable('#ordertabtwo', '#OrderHistory', '#OrderHistory');
					// }, 100);

					// setTimeout(() => {
					// 	atualizarDataTable('#ordertabthree', '#TradeHistory', '#TradeHistory');
					// }, 300);

					// setTimeout(() => {
					// 	atualizarDataTable('#ordertabone', '#OpenOrder', '#OpenOrder');
					// }, 500);
				});
			});
			
			function atualizarDataTable(idtable, idhtml, selectorAba) {
				$('a[href="' + selectorAba + '"]').tab('show');
				if ($(selectorAba).hasClass('active')) {
					if ($.fn.DataTable.isDataTable(idtable)) {
						var oldTableHtml = $(idtable).prop('outerHTML');
						$(idtable).DataTable().destroy();
						$(idhtml).html(oldTableHtml);
					}
					$(idtable).DataTable({
						responsive: true,
					});
				}
			}

			function updateCoin(coin) {
					Livewire.emit('updatecoin', coin);
					document.getElementById('dropdownMenuButton').textContent = coin;
			}
		</script>
	</body>

</html>>