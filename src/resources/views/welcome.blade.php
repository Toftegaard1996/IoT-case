<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Sensor Data</title>
{{--    @vite('resources/js/app.js')--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
</head>
<body>
<canvas id="sensorChart" width="400" height="200"></canvas>

<script>
console.log('Initializing chart...');

const ctx = document.getElementById('sensorChart').getContext('2d');
const sensorChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [], // Timestamps
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: false,
                tension: 0.1
            }, {
                label: 'Humidity',
                data: [],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'minute', // Adjust this as needed, you might use 'second' or 'hour'
                        stepSize: 50,    // You can adjust this stepSize based on your data frequency
                        tooltipFormat: 'll HH:mm'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    console.log('Chart initialized.');

    // Function to update the chart with new sensor data
    function updateSensorChart(data) {
        console.log('Updating chart with new data:', data);

        // Ensure that the timestamp is in a format that can be correctly parsed
        const timestamp = new Date(data.Timestamp);

        if (isNaN(timestamp)) {
            console.error('Invalid Date:', data.Timestamp);
        } else {
            console.log('Timestamp parsed:', timestamp);
            sensorChart.data.labels.push(timestamp);
            sensorChart.data.datasets[0].data.push(data.Temperature);
            sensorChart.data.datasets[1].data.push(data.Humidity);
            sensorChart.update();
        }
    }

    // Fetch existing data from the server on page load
    fetch('/update-sensor')
        .then(response => {
            console.log('Fetching existing data...');
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data);
            data.forEach(sensorData => {
                updateSensorChart(sensorData);
            });
        })
        .catch(error => console.error('Error fetching data:', error));

    // Listen for real-time updates
    setTimeout(() => {
        const sensorChannel = window.Echo.channel('sensor-channel');
        console.log('Subscribed to sensor-channel');

        sensorChannel.listen('SensorDataUpdated', (e) => {
            console.log('New sensor data received:', e.sensorData);
            // Since e.sensorData is likely a single object, we update directly
            updateSensorChart(e.sensorData);
        });
    }, 200);

    if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
        window.Echo.connector.pusher.connection.bind('connected', function() {
            console.log('Connected to Pusher!');
        });
    } else {
        console.error('Echo is not defined properly.');
    }
</script>


</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Sensor Data</title>
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script> <!-- Date adapter -->
</head>
<body>
{{--<!-- @vite(['resources/js/echo.js']) -->--}}

<canvas id="sensorChart" width="400" height="200"></canvas> <!-- Canvas for Chart -->

<script>
    console.log('Initializing chart...');

    // Initialize the chart
    const ctx = document.getElementById('sensorChart').getContext('2d');
    const sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Timestamps
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: false,
                tension: 0.1,
                spanGaps: true  // Allow gaps in the line
            }, {
                label: 'Humidity',
                data: [],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: false,
                tension: 0.1,
                spanGaps: true  // Allow gaps in the line
            }]
        },
        options: {
            animation: {
                duration: 0 // set to 0 to disable animation completely or to a lower value like 200 for fast animations
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'minute',
                        tooltipFormat: 'll HH:mm',
                        displayFormats: {
                            'minute': 'HH:mm',
                            'hour': 'MMM D, HH:mm',
                            'day': 'MMM D'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Function to update the chart with new sensor data
    function updateSensorChart(data, reset = false) {
        if (reset) {
            resetChartData();
        }
        console.log('Updating chart with new data:', data);

        const timestamp = moment(data.Timestamp).toDate(); // Convert to JavaScript Date using moment.js
        console.log('Timestamp parsed:', timestamp);

        sensorChart.data.labels.push(timestamp);
        sensorChart.data.datasets[0].data.push(data.Temperature);
        sensorChart.data.datasets[1].data.push(data.Humidity);
        sensorChart.update();
    }

    // Function to reset the chart data
    function resetChartData() {
        sensorChart.data.labels = [];
        sensorChart.data.datasets.forEach(dataset => {
            dataset.data = [];
        });
    }

    // Function to refresh the chart with all data from the server
    function refreshChart() {
        console.log('Fetching all data from server...');
        fetch('/update-sensor')
            .then(response => response.json())
            .then(data => {
                console.log('Data fetched from server:', data);
                resetChartData();  // Clear previous data
                data.forEach(sensorData => {
                    updateSensorChart(sensorData, false);
                });
            })
            .catch(error => console.error('Error fetching data from server:', error));
    }

    // Fetch existing data from the server on page load
    refreshChart();

    // Listen for real-time updates
    setTimeout(() => {
        const sensorChannel = window.Echo.channel('sensor-channel');
        console.log('Subscribed to sensor-channel');

        sensorChannel.listen('SensorDataUpdated', (e) => {
            console.log('New sensor data received:', e.sensorData);

            // Fetch all data again to ensure consistency
            refreshChart();
        });
    }, 200);

</script>
</body>
</html>
