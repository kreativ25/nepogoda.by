var ctx = document.getElementById('myChart').getContext('2d');

//var temp =  "<?php echo $json__encode_temp_chart; ?>";

var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "Прогноз температуры:",

            borderColor: 'rgb(255, 99, 132)',
            data: [5, 10, 5, 2, 20, 30, 45],
        }]
    },

    // Configuration options go here
    options: {}
});