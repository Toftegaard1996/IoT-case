<template>
  <div>
    <!-- Canvas elementet hvor grafen vil blive tegnet -->
    <canvas :id="'chart-' + roomName"></canvas>
  </div>
</template>

<script>
import {
  Chart,
  LineController,
  LineElement,
  PointElement,
  LinearScale,
  Title,
  CategoryScale,
  TimeScale,
} from "chart.js";
import "chartjs-adapter-date-fns";

// Registrer nødvendige komponenter eksplicit
Chart.register(
  LineController,
  LineElement,
  PointElement,
  LinearScale,
  Title,
  CategoryScale,
  TimeScale
);

export default {
    props: {
        roomName: String,
        temperatureData: Array, // Array of temperature data received as a prop
        showYesterday: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            chartInstance: null,  // Store the chart instance here
            localTemperatureData: [...this.temperatureData], // Copy prop to local data
        };
    },
    watch: {
        // Watch for changes in the prop and update the local data property
        temperatureData(newData) {
            this.localTemperatureData = [...newData];
            this.renderChart();  // Re-render the chart when temperatureData changes
        }
    },
    mounted() {
        console.log("Initial Temperatur Data:", this.localTemperatureData); // Debugging log
        this.renderChart();

        // Listen for real-time updates after mounting
        setTimeout(() => {
            const sensorChannel = window.Echo.channel('sensor-channel');
            console.log('Subscribed to sensor-channel');

            sensorChannel.listen('SensorDataUpdated', (e) => {
                console.log('New sensor data received:', e.sensorData);

                // Update the local temperature data, not the prop
                this.localTemperatureData = [...e.sensorData];
                this.renderChart();
            });
        }, 200);
    },
    methods: {
        renderChart() {
            //Destroy the existing chart if it exists
            if (this.chartInstance) {
                this.chartInstance.destroy();
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const startDate = this.showYesterday
                ? new Date(today.setDate(today.getDate() - 1))
                : today;
            const endDate = this.showYesterday
                ? new Date(today.setDate(today.getDate() + 1))
                : new Date();

            const filteredData = this.localTemperatureData.filter((data) => {
                const date = new Date(data.created_at);
                return date >= startDate && date < endDate;
            });

            const labels = filteredData.map((data) => {
                const date = new Date(data.created_at);
                return date;
            });

            const temperatures = filteredData.map((data) => {
                const temp = parseFloat(data.temp);
                return temp;
            });

            const ctx = document.getElementById("chart-" + this.roomName).getContext("2d");

            // Create the new chart and store the instance
            this.chartInstance = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Temperatur",
                            data: temperatures,
                            borderColor: "rgba(75, 192, 192, 1)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            type: "time",
                            time: {
                                unit: "minute",
                                tooltipFormat: "MMM dd, yyyy HH:mm",
                                displayFormats: {
                                    minute: "HH:mm",
                                    hour: "MMM dd, HH:mm",
                                },
                            },
                            title: {
                                display: true,
                                text: "Tidsstempel",
                            },
                        },
                        y: {
                            type: "linear",
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "Temperatur (Â°C)",
                            },
                        },
                    },
                },
            });
        },
    },
};



</script>
