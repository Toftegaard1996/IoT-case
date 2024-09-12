<script setup lang="ts">
// Importer nødvendige hooks og komponenter
import { ref, onMounted } from "vue";
import axios from "axios";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import type { OfficeRooms, Settings } from "@/Types";
import GreenButton from "@/Components/GreenButton.vue";
import FormNewSettings from "@/Components/FormNewSettings.vue";

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
    await groupDataByRoom();
  } catch (error) {
    console.error("Error fetching sensor data:", error);
  }
};

// Funktion til at hente indstillinger for et specifikt rum fra API
const fetchRoomSettings = async (roomName) => {
  try {
    // Send GET-anmodning til API for at hente rumindstillinger
    const response = await axios.get(
      `http://192.168.1.125:8000/settings/${roomName}`
    );
    return response.data;
  } catch (error) {
    console.error(`Error fetching settings for room ${roomName}:`, error);
    return null;
  }
};

// Funktion til at gruppere sensor data efter rum
const groupDataByRoom = async () => {
  // Reducer sensorData til et objekt grupperet efter roomName
  const grouped = sensorData.value.reduce((acc, data) => {
    if (!acc[data.roomName]) {
      acc[data.roomName] = [];
    }
    // Tilføj data til det relevante rum
    acc[data.roomName].push({
      temp: parseFloat(data.temp),
      humidity: parseFloat(data.humidity),
      created_at: data.created_at ? new Date(data.created_at) : new Date(),
    });
    return acc;
  }, {});

  console.log("Grouped Data Before Settings:", grouped); // Debugging log

  // Hent og tilføj indstillinger for hvert rum
  for (const roomName in grouped) {
    const settings = await fetchRoomSettings(roomName);
    grouped[roomName].settings = settings;
  }

  console.log("Grouped Data After Settings:", grouped); // Debugging log

  // Opdater groupedData med de grupperede data
  groupedData.value = grouped;
};

// Funktion til at opdatere sensor data fra serveren
const refreshSensorData = async () => {
  console.log("Fetching all data from server...");
  try {
    const response = await axios.get("/update-sensorUno");
    console.log("Data fetched from server:", response.data);
    sensorData.value = response.data;
    await groupDataByRoom();
  } catch (error) {
    console.error("Error fetching data from server:", error);
  }
};

// Funktion til at opsætte real-time opdateringer
const setupRealTimeUpdates = () => {
  setTimeout(() => {
    const sensorChannel = window.Echo.channel("sensor-channel");
    console.log("Subscribed to sensor-channel");

    sensorChannel.listen("SensorDataUpdated", async (e) => {
      console.log("New sensor data received:", e.sensorData);
      // Fetch all data again to ensure consistency
      await refreshSensorData();
    });
  }, 200);
};

// Kør fetchSensorData når komponenten er monteret
onMounted(() => {
  fetchSensorData();
  setupRealTimeUpdates();
});
</script>

<template>
  <!-- Sæt sidehovedet -->
  <Head title="Dagens graf" />

  <!-- Brug AuthenticatedLayout til at omgive indholdet -->
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Aktuel temperatur og fugtighedsoversigt
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            Aktuel temperatur og fugtighedsoversigt
            <!-- Loop gennem hvert rum i groupedData og vis dets data -->
            <div
              v-for="(data, roomName) in groupedData"
              :key="roomName"
              class="room-overview"
            >
              <h3>{{ roomName }}</h3>
              <p>Temperatur: {{ data[0].temp }} °C</p>
              <p>Fugtighed: {{ data[0].humidity }} %</p>

              <!-- Vis advarsler baseret på rumindstillinger -->
              <div v-if="data.settings">
                <p
                  v-if="
                    data[data.length - 1].temp > data.settings.maxTemp ||
                    data[data.length - 1].temp < data.settings.minTemp
                  "
                >
                  ⚠️ Advarsel: Temperaturen er uden for grænserne!
                </p>
                <p v-else>😊 Temperaturen er inden for grænserne.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.room-overview {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 10px;
}
</style>
