var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',

    data: {
        labels: ["Январь", "февраль", " vfhn"],
        datasets: [{
            label: "Прогноз температуры",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: json__encode_temp_chart,
        }]
    },

    options: {}
});