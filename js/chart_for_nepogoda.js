var chartData = {
    labels: json__encode_data_chart,
    datasets: [
        {
            label: "Прогноз температуры", //название графика
            borderColor: 'rgb(255, 99, 132)', //Цвет линии
            data: json__encode_temp_chart,
            pointBackgroundColor: 'rgb(221, 100, 127)', //Цвет границы для точек
            backgroundColor: 'rgba(0, 0, 0, 0.03)', //Цвет заливки под линией
            pointRadius: 2, //Радиус формы точки
            borderWidth: 2 //ширина линии в пикселях


        }
    ]
};

var opt = {
    legend: {
        display: false,
        labels: {
            fontColor: 'rgb(255, 99, 132)',

        }
    },
    events: true,
    tooltips: {
        enabled: true
    },
    hover: {
        animationDuration: 0
    },
    animation: {
        duration: 1,
        onComplete: function () {
            var chartInstance = this.chart,
                ctx = chartInstance.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';

            this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                meta.data.forEach(function (bar, index) {
                    var data = dataset.data[index];
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                });
            });
        }
    }
};
var ctx = document.getElementById("myChart"),
    myLineChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: opt
    });


/*
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',

    data: {
        labels: json__encode_data_chart,
        datasets: [{
            label: "Прогноз температуры",
            borderColor: 'rgb(255, 99, 132)',
            data: json__encode_temp_chart,
        }]
    },

    options: {
        legend: {
            display: true,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },

        scales: {
            yAxes: [{
                ticks:{
                    beginAtZero: true
                }
            }],
            xAxes: [{
                ticks:{
                    autoSkip: true,
                    maxTickslimit: 3
                }
            }],
        }
    }
});
*/
