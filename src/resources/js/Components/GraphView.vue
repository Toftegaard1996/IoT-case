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
        temperatureData: Array,
        showYesterday: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            chartInstance: null, // Store the chart instance here
        };
    },
    mounted() {
        console.log("Temperatur Data:", this.temperatureData);
        this.renderChart();

        // Use setTimeout to listen for real-time updates after mounting
        setTimeout(() => {
            const sensorChannel = window.Echo.channel('sensor-channel');
            console.log('Subscribed to sensor-channel');

            sensorChannel.listen('SensorDataUpdated', (e) => {
                console.log('New sensor data received:', e.sensorData);

                // Update the temperature data and re-render the chart
                this.temperatureData = e.sensorData;
                this.renderChart();
            });
        }, 200);
    },
    methods: {
        renderChart() {
            // Destroy the existing chart if it exists
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

            const filteredData = this.temperatureData.filter((data) => {
                const date = new Date(data.created_at);
                return date >= startDate && date < endDate;
            });

            const labels = filteredData.map((data, index) => {
                const date = new Date(data.created_at);
                return date;
            });

            const temperatures = filteredData.map((data, index) => {
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
