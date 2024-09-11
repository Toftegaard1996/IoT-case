<script setup lang="ts">
// Importer nødvendige komponenter og hooks
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import GraphView from "@/Components/GraphView.vue";

// Definer reaktive variabler til at holde sensor data og grupperede data
const sensorData = ref([]);
const groupedData = ref({});

// Funktion til at hente sensor data fra API
const fetchSensorData = async () => {
  try {
    // Send GET-anmodning til API for at hente sensor data
    const response = await axios.get("http://192.168.1.125:8000/update-sensor");
    console.log("API Response:", response.data); // Debugging log
    // Opdater sensorData med data fra API-responsen
    sensorData.value = response.data;
    // Kald funktion til at gruppere data efter rum
    groupDataByRoom();
  } catch (error) {
    console.error("Error fetching sensor data:", error);
  }
};

// Funktion til at gruppere sensor data efter rum
const groupDataByRoom = () => {
  groupedData.value = sensorData.value.reduce((acc, data) => {
    // Hvis rummet ikke allerede findes i acc, initialiser det som en tom array
    if (!acc[data.roomName]) {
      acc[data.roomName] = [];
    }
    // Tilføj data til det relevante rum
    acc[data.roomName].push({
      temp: parseFloat(data.temp),
      created_at: data.created_at ? new Date(data.created_at) : new Date(),
    });
    return acc;
  }, {});
};

// Kør fetchSensorData når komponenten er monteret
onMounted(() => {
  fetchSensorData();
});
</script>

<template>
  <!-- Sæt sidehovedet -->
  <Head title="Yesterday's graph" />

  <!-- Brug AuthenticatedLayout til at omgive indholdet -->
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Gårsdagens grafer
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            Her kan du se gårsdagens grafer for temperaturer i kontoret
            <!-- Loop gennem hvert rum i groupedData og vis dets graf -->
            <div v-for="(temps, roomName) in groupedData" :key="roomName">
              <p>{{ roomName }}</p>
              <!-- Pas rum-specifikke data til GraphView komponenten -->
              <GraphView
                :roomName="roomName"
                :temperatureData="temps"
                :showYesterday="true"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
