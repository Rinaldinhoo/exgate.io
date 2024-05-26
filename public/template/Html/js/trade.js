    var prices = [];
    var label = [];
    var previousPrice = 0;
    var amount = 0;

    const rangeInput = document.querySelector('.form-range');

    const inputWallet = document.getElementById('wallet_74yr64');
    const inputMargem = document.getElementById('margem_74yr64');


    function formatData(string)
    {
        const dateObj = new Date(string);

        const formattedDate = `${String(dateObj.getDate()).padStart(2, '0')}/${String(dateObj.getMonth() + 1).padStart(2, '0')}, ${String(dateObj.getHours()).padStart(2, '0')}:${String(dateObj.getMinutes()).padStart(2, '0')}`;

        return formattedDate;

    }

    rangeInput.addEventListener('input', (event) => {
        // const walletMargin = parseFloat(inputWallet.value) * (parseFloat(inputMargem.value / 100));
        const walletMargin = parseFloat(inputMargem.value );
        // alert(parseFloat(inputWallet.value)+' '+(inputMargem.value / 100) + ' '+inputMargem.value);
         let percentageValue;
    
        switch(event.target.value) {
            case '1':
                percentageValue = 0; // 0%
                break;
            case '2':
                percentageValue = 0.25; // 25%
                break;
            case '3':
                percentageValue = 0.5; // 50%
                break;
            case '4':
                percentageValue = 0.75; // 75%
                break;
            case '5':
                percentageValue = 1; // 100%
                break;
            default:
                percentageValue = 0;
                break;
        }
    
        let coin = document.getElementById('dropdownMenuButton').textContent;
        let walletMarginPercentage= 0;
        if (coin == 'USDT') {
            walletMarginPercentage = walletMargin * percentageValue;
        } else {
            walletMarginPercentage = walletMargin * percentageValue;
        }

        Livewire.emit('updateAmount', walletMarginPercentage);
        Livewire.emit('updatePriceBuySell', walletMarginPercentage);
    
    });

   

/*
    Pusher.logToConsole = true;

    var pusher = new Pusher('518c52d6b6be2b9a8c08', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('bitcoin-prices');
    channel.bind('App\Events\NewBitcoinPrice', function(data) {

 
    });
*/



$(document).ready(function() {
    var options = {
        chart: {
            height: 600,
            type: 'candlestick',
            background: '#1e1f1e',
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                },
                autoSelected: 'pan' // Pode alternar para 'pan' conforme preferência
            },
            zoom: {
                enabled: true,
                type: 'x', // Zoom apenas no eixo X
                autoScaleYaxis: true // Ajusta automaticamente o eixo Y ao fazer zoom
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        plotOptions: {
            candlestick: {
                colors: {
                    upward: '#26a32a',
                    downward: '#ff0400'
                },
                wick: {
                    useFillColor: true
                }
            }
        },
        series: [{
            data: []
        }],
        xaxis: {
            type: 'datetime'
        },
        yaxis: {
            tooltip: {
                enabled: true
            },
            labels: {
                align: 'right'
            },
            opposite: true // Isso posiciona o eixo Y no lado direito
        }
    };

    var chart = new ApexCharts(document.querySelector("#myChart"), options);
    chart.render();

    function updateChart(pricingData) {
        const transformedData = pricingData.map(data => ({
            x: new Date(data.time_open),
            y: [
                parseFloat(data.price_open),
                parseFloat(data.max),
                parseFloat(data.min),
                parseFloat(data.price_close)
            ]
        }));

        chart.updateSeries([{ data: transformedData }]);
    }

    async function updatePrice() {
     
        try {
            const response = await fetch('https://app.exgate.io/api/last-pricing');
    
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
    
            const data = await response.json();

            const btcusdtValue = parseFloat(data.askPrice).toFixed(2);
    
            const priceElement = document.getElementById('price_44456');

            const priceInputElement = document.getElementById('price_84dee');

            const priceInputOElement = document.getElementById('price_84dae');

            const priceInputFElement = document.getElementById('price_85dae');

            priceInputElement.value = data.askPrice;

            priceInputOElement.innerHTML = `BTC/USDT ${parseFloat(data.askPrice).toFixed(2)}`

            priceInputFElement.innerHTML = `BTC/USDT ${parseFloat(data.askPrice).toFixed(2)}`

            priceElement.innerHTML = `BTC/USDT ${btcusdtValue}`; 

            handlePrices();

            setTimeout(() => {
                Livewire.emit('updatePrice', data.askPrice);
            }, 2000);

          //  Livewire.emit('updatePrice', data.askPrice);

        } catch (error) {
            console.error('Failed to update price:', error);
        }
    }

    async function handlePrices() {

        try {
            // Fazendo a chamada fetch de maneira assíncrona
            const response = await fetch('https://app.exgate.io/api/pricing');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // Aguarda a conversão da resposta para JSON
            const data = await response.json();
            updateChart(data);
     
    
        } catch (error) {
            console.error('Erro ao buscar os dados:', error);
        }
    }


    setInterval(updatePrice, 30000);

    updatePrice();

    handlePrices();

});





