function inicializarComponentes() {
    // Inicialização do widget da TradingView
    chartLoad(localStorage.getItem('theme') || 'light');

    // Inicialização dos DataTables
    inicializarDataTables();

    // Listener para a troca de temas
    configurarListenersDeTema();
}

function chartLoad(chartTheme) {
    // Substitua pelo código de inicialização do seu widget da TradingView
    console.log(`Carregando o tema do gráfico: ${chartTheme}`);
    // Exemplo: Inicialização do widget TradingView (substitua pelos seus parâmetros)
    new TradingView.widget({
        "autosize": true,
        "symbol": "BITSTAMP:BTCUSD",
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": chartTheme,
        "style": "1",
        "locale": "in",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "withdateranges": true,
        "hide_side_toolbar": false,
        "allow_symbol_change": true,
        "details": true,
        "hotlist": true,
        "calendar": true,
        "container_id": "tradingview_e05b7"
    });
}

function inicializarDataTables() {
    // Destrua as instâncias anteriores antes de reinicializar
    if ($.fn.DataTable.isDataTable('.dataTable')) {
        $('.dataTable').DataTable().clear().destroy();
    }
    $('.dataTable').DataTable({
        responsive: true,
        columnDefs: [{ targets: [-1, -3], className: 'dt-body-right' }]
    });
}

function configurarListenersDeTema() {
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    var toggleHcSwitch = document.querySelector('.theme-high-contrast input[type="checkbox"]');

    if (toggleSwitch) {
        toggleSwitch.removeEventListener('change', switchTheme);
        toggleSwitch.addEventListener('change', switchTheme, false);
    }
    if (toggleHcSwitch) {
        toggleHcSwitch.removeEventListener('change', switchTheme);
        toggleHcSwitch.addEventListener('change', switchTheme, false);
    }
}

function switchTheme(e) {
    // Função para alternar entre temas claro e escuro
    var theme = e.target.checked ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    chartLoad(theme); // Atualiza o tema do gráfico
}

// Quando o DOM estiver pronto
$(document).ready(function() {
    inicializarComponentes();
});

// Para reinicializar componentes após atualizações do Livewire
document.addEventListener('livewire:load', function() {
    inicializarComponentes();
    
    // Adicione aqui outros hooks do Livewire se necessário
});
$(document).ready(function() {
async function updatePrice() {
     
    try {
        const response = await fetch('https://economia.awesomeapi.com.br/last/USD-BRL');

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        const btcusdtValue = parseFloat(data.USDBRL.ask).toFixed(2);

        // const priceElement = document.getElementById('price_44456');

        // const priceInputElement = document.getElementById('price_84dee');

        // priceInputElement.value = data.askPrice;

        // priceElement.innerHTML = `BTC/USDT ${btcusdtValue}`; 

        Livewire.emit('updatePrice', data.USDBRL.ask);
        setTimeout(() => {
            Livewire.emit('updatePrice', data.USDBRL.ask);
        }, 2000);

      //  Livewire.emit('updatePrice', data.askPrice);
        let totalbuy = document.getElementById('totalbuy').value;
        let totalsell = document.getElementById('totalsell').value;
        if (totalbuy) {
            // document.getElementById("amountbuy").value = (totalbuy / document.getElementById('pricenow').value);
        }else {
            document.getElementById("amountbuy").value = "";
		}

        if (totalsell) {
            // document.getElementById("amountsell").value = (totalsell / document.getElementById('pricenow').value).toFixed(8);
        }else {
            document.getElementById("amountsell").value = "";
		}

    } catch (error) {
        console.error('Failed to update price:', error);
    }
}

setInterval(updatePrice, 5000);

updatePrice();
});