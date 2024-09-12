<template>
  <div>
    <h2>{{ roomName }} Temperature Graph</h2>
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

// Register necessary components explicitly
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
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = document
        .getElementById("chart-" + this.roomName)
        .getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: this.temperatureData.map((data) => new Date(data.created_at)),
          datasets: [
            {
              label: "Temperature",
              data: this.temperatureData.map((data) => parseFloat(data.temp)),
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
                text: "Timestamp",
              },
            },
            y: {
              type: "linear",
              beginAtZero: true,
              title: {
                display: true,
                text: "Temperature (°C)",
              },
            },
          },
        },
      });
    },
  },
};
</script>
