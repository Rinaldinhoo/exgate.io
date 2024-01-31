(function() {
  "use strict";
    
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

