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

