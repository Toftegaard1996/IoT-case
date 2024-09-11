<template>
  <div>
    <h2>Her kan du se dagens temperaturgraf for {{ roomName }}</h2>
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
  },
  mounted() {
    console.log("Temperatur Data:", this.temperatureData); // Debugging log
    this.renderChart();
  },
  methods: {
    renderChart() {
      const today = new Date();
      today.setHours(0, 0, 0, 0); // Sæt til starten af dagen

      const filteredData = this.temperatureData.filter((data) => {
        const date = new Date(data.created_at);
        return date >= today;
      });

      const labels = filteredData.map((data, index) => {
        console.log(`Data Element ${index}:`, data); // Debugging log
        const date = new Date(data.created_at);
        console.log("Rå created_at:", data.created_at); // Debugging log
        console.log("Parset Dato:", date); // Debugging log
        return date;
      });

      const temperatures = filteredData.map((data, index) => {
        console.log(`Data Element ${index}:`, data); // Debugging log
        const temp = parseFloat(data.temp);
        console.log("Rå temp:", data.temp); // Debugging log
        console.log("Parset Temperatur:", temp); // Debugging log
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
                text: "Temperatur (°C)",
              },
            },
          },
        },
      });
    },
  },
};
</script>
