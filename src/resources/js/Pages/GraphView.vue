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
    console.log("Temperature Data:", this.temperatureData); // Debugging log
    this.renderChart();
  },
  methods: {
    renderChart() {
      const labels = this.temperatureData.map((data, index) => {
        console.log(`Data Item ${index}:`, data); // Debugging log
        const date = new Date(data.created_at);
        console.log("Raw created_at:", data.created_at); // Debugging log
        console.log("Parsed Date:", date); // Debugging log
        return date;
      });

      const temperatures = this.temperatureData.map((data, index) => {
        console.log(`Data Item ${index}:`, data); // Debugging log
        const temp = parseFloat(data.temp);
        console.log("Raw temp:", data.temp); // Debugging log
        console.log("Parsed Temperature:", temp); // Debugging log
        return temp;
      });

      const ctx = document
        .getElementById("chart-" + this.roomName)
        .getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Temperature",
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
