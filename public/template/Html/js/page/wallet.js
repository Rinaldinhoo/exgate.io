/*
* Admin Layout (cryptoon)
* @author: Pixelwibes
* @design by: Pixelwibes.
* @event-namespace:cryptoon
* Copyright 2021 Pixelwibes
*/

if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function() {
    "use strict";
    // SIMPLE DONUT
    $(document).ready(function() {

    
          // Seleciona os elementos
        var dataSell = document.querySelector('[data-sell]').getAttribute('data-sell');
        var dataBuy = document.querySelector('[data-buy]').getAttribute('data-buy');
        var dataAmount = document.querySelector('[data-amount]').getAttribute('data-amount');

        console.log(dataBuy)

      var options = {
          chart: {
              height: 250,
              type: 'donut',
          },
          dataLabels: {
              enabled: false,
          },
          legend: {
              position: 'right',
              horizontalAlign: 'center',
              show: true,
          },
          colors: ['var(--chart-color1)', 'var(--chart-color2)', 'var(--chart-color3)'],
          series: [parseFloat(dataSell), parseFloat(dataBuy), parseFloat(dataAmount)],
          labels: ['VENDA','COMPRA', 'USDT'], 
          responsive: [{
              breakpoint: 480,
              options: {
                  chart: {
                      width: 200
                  },
                  legend: {
                      position: 'bottom'
                  }
              }
          }]
      }

      var chart = new ApexCharts(
          document.querySelector("#apex-simple-donut"),
          options
      );
      
      chart.render();
    });

});

