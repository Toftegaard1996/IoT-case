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
  // Definer props som komponenten modtager
  props: {
    roomName: String, // Navnet på rummet
    temperatureData: Array, // Array af temperaturdata
    showYesterday: {
      type: Boolean,
      default: false, // Boolean for at vise gårsdagens data
    },
  },
  mounted() {
    console.log("Temperatur Data:", this.temperatureData); // Debugging log
    // Kald renderChart metoden når komponenten er monteret
    this.renderChart();
  },
  methods: {
    renderChart() {
      // Få dagens dato og sæt tiden til midnat
      const today = new Date();
      today.setHours(0, 0, 0, 0); // Sæt til starten af dagen

      // Bestem start- og slutdato baseret på showYesterday prop
      const startDate = this.showYesterday
        ? new Date(today.setDate(today.getDate() - 1))
        : today;
      const endDate = this.showYesterday
        ? new Date(today.setDate(today.getDate() + 1))
        : new Date();

      // Filtrer temperaturdataene for at inkludere kun de relevante datoer
      const filteredData = this.temperatureData.filter((data) => {
        const date = new Date(data.created_at);
        return date >= startDate && date < endDate;
      });

      // Opret labels array fra de filtrerede data
      const labels = filteredData.map((data, index) => {
        console.log(`Data Element ${index}:`, data); // Debugging log
        const date = new Date(data.created_at);
        console.log("Rå created_at:", data.created_at); // Debugging log
        console.log("Parset Dato:", date); // Debugging log
        return date;
      });

      // Opret temperatur array fra de filtrerede data
      const temperatures = filteredData.map((data, index) => {
        console.log(`Data Element ${index}:`, data); // Debugging log
        const temp = parseFloat(data.temp);
        console.log("Rå temp:", data.temp); // Debugging log
        console.log("Parset Temperatur:", temp); // Debugging log
        return temp;
      });

      // Få konteksten for canvas elementet og opret en ny Chart
      const ctx = document
        .getElementById("chart-" + this.roomName)
        .getContext("2d");
      new Chart(ctx, {
        type: "line", // Typen af graf
        data: {
          labels: labels, // Labels for x-aksen
          datasets: [
            {
              label: "Temperatur", // Label for datasættet
              data: temperatures, // Data for y-aksen
              borderColor: "rgba(75, 192, 192, 1)", // Farve for linjen
              borderWidth: 1, // Bredde for linjen
            },
          ],
        },
        options: {
          scales: {
            x: {
              type: "time", // Typen af x-aksen
              time: {
                unit: "minute", // Enheden for tid
                tooltipFormat: "MMM dd, yyyy HH:mm", // Format for tooltip
                displayFormats: {
                  minute: "HH:mm", // Format for minut
                  hour: "MMM dd, HH:mm", // Format for time
                },
              },
              title: {
                display: true, // Vis titel for x-aksen
                text: "Tidsstempel", // Tekst for x-aksens titel
              },
            },
            y: {
              type: "linear", // Typen af y-aksen
              beginAtZero: true, // Start ved nul
              title: {
                display: true, // Vis titel for y-aksen
                text: "Temperatur (°C)", // Tekst for y-aksens titel
              },
            },
          },
        },
      });
    },
  },
};
</script>
