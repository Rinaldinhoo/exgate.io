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
    // const chart = LightweightCharts.createChart(document.getElementById('myChart'), {
    //     width: window.innerWidth,
    //     height: 600,
    //     layout: {
    //         backgroundColor: '#1e1f1e',
    //         textColor: 'rgba(255, 255, 255, 0.9)',
    //     },
    //     grid: {
    //         vertLines: {
    //             color: 'rgba(197, 203, 206, 0.5)',
    //         },
    //         horLines: {
    //             color: 'rgba(197, 203, 206, 0.5)',
    //         },
    //     },
    //     priceScale: {
    //         borderColor: 'rgba(197, 203, 206, 0.8)',
    //     },
    //     timeScale: {
    //         borderColor: 'rgba(197, 203, 206, 0.8)',
    //     },
    // });

    // const candleSeries = chart.addCandlestickSeries({
    //     upColor: '#4caf50',
    //     downColor: '#f44336',
    //     borderDownColor: '#f44336',
    //     borderUpColor: '#4caf50',
    //     wickDownColor: '#f44336',
    //     wickUpColor: '#4caf50',
    // });
    
    async function fetchCandleData() {
        try {
            const response = await fetch('/api/klines'); // URL da sua API
            const data = await response.json();
            const candleData = data.pricingData.map(candle => ({
                time: new Date(candle.time_open).getTime() / 1000, // Converter para timestamp em segundos
                open: parseFloat(candle.price_open),
                high: parseFloat(candle.max),
                low: parseFloat(candle.min),
                close: parseFloat(candle.price_close),
            }));
            candleSeries.setData(candleData);
        } catch (error) {
            console.error('Failed to fetch candle data:', error);
        }
    }

    async function updateCandleData() {
        try {
            const response = await fetch('/api/klines'); // URL da sua API
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            const lastCandle = {
                time: new Date(data.time_open).getTime() / 1000, // Converter para timestamp em segundos
                open: parseFloat(data.price_open),
                high: parseFloat(data.max),
                low: parseFloat(data.min),
                close: parseFloat(data.price_close),
            };
            candleSeries.update(lastCandle);
        } catch (error) {
            console.error('Failed to update candle data:', error);
        }
    }

    //fetchCandleData();
    //setInterval(updateCandleData, 5000); // Atualiza a cada 5 segundos

    async function updatePrice() {
     
        try {
            const response = await fetch('/api/last-pricing');
    
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

            setTimeout(() => {
                Livewire.emit('updatePrice', data.askPrice);
            }, 2000);

          //  Livewire.emit('updatePrice', data.askPrice);

        } catch (error) {
            console.error('Failed to update price:', error);
        }
    }


    setInterval(updatePrice, 3000);

    updatePrice();

});





