(function() {
  "use strict";
  var randomizeArray = function (arg) {
    var array = arg.slice();
    var currentIndex = array.length,
    temporaryValue, randomIndex;

    while (0 !== currentIndex) {  
        randomIndex = Math.floor(Math.random() * currentIndex);  
        currentIndex -= 1;

        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }  
    return array;
    }

    // data for the sparklines that appear below header area
    var sparklineData = [47, 45, 54, 38, 56, 47, 45, 54, 38, 56, 38, 56, 24, 65, 31];

    // topb big chart    
    var spark1 = {
        chart: {
            type: 'area',
        
            height: 30,
            sparkline: {
            enabled: true
            },
        },
        stroke: {
            width: 1
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        colors: ['#f8921a'],
    }
    var spark1 = new ApexCharts(document.querySelector("#apexspark1"), spark1); spark1.render();

    var spark2 = {
        chart: {
            type: 'area',
        
            height: 30,
            sparkline: {
            enabled: true
            },
        },
        stroke: {
            width: 1
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        colors: ['#0077af'],
    }
    var spark2 = new ApexCharts(document.querySelector("#apexspark2"), spark2); spark2.render();

    var spark3 = {
        chart: {
            type: 'area',
        
            height: 30,
            sparkline: {
            enabled: true
            },
        },
        stroke: {
            width: 1
        },
        colors: ['#6fb92c'],
        series: [{
            data: randomizeArray(sparklineData)
        }],
    }
    var spark3 = new ApexCharts(document.querySelector("#apexspark3"), spark3); spark3.render();

    var spark4 = {
        chart: {
            type: 'area',
            height: 30,
            sparkline: {
            enabled: true
            },
        },
        stroke: {
            width: 1
        },
        colors: ['#141414'],
        series: [{
            data: randomizeArray(sparklineData)
        }],
    }
    var spark4 = new ApexCharts(document.querySelector("#apexspark4"), spark4); spark4.render();
    
})()

var pageLink = document.querySelectorAll('.page-scroll');
    pageLink.forEach(elem => {
    elem.addEventListener('click', e => {
        e.preventDefault();
        document.querySelector(elem.getAttribute('href')).scrollIntoView({
            behavior: 'smooth',
            offsetTop: 1000,
        });
    });
});


chartLoad(localStorage.getItem('theme'));
const setTheme = (theme) => {
document.documentElement.setAttribute('data-theme', theme);
localStorage.setItem('theme', theme); //add this
    chartLoad(theme)
};

var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
var toggleHcSwitch = document.querySelector('.theme-high-contrast input[type="checkbox"]');

toggleSwitch.addEventListener('change', switchTheme, false);
toggleHcSwitch.addEventListener('change', switchTheme, false);

function switchTheme(e) {
    setTheme(e.target.checked ? 'dark' : 'light');
}
function chartLoad(chartTheme) {
    //chart
    new TradingView.widget(
        {
            "autosize": true,
            "symbol": "BINANCE:BTCUSDT",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": chartTheme,
            "style": "1",
            "locale": "in",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_85dc0"
        }
    );
}

