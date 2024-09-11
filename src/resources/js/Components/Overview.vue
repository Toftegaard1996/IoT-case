<template>
  <Head title="Dagens graf" />

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
            <div
              v-for="(data, roomName) in groupedData"
              :key="roomName"
              class="room-overview"
            >
              <h3>{{ roomName }}</h3>
              <p>Temperatur: {{ data[data.length - 1].temp }} °C</p>
              <p>Fugtighed: {{ data[data.length - 1].humidity }} %</p>
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

<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";

const sensorData = ref([]);
const groupedData = ref({});

const fetchSensorData = async () => {
  try {
    const response = await axios.get("http://192.168.1.125:8000/update-sensor");
    console.log("API Response:", response.data); // Debugging log
    sensorData.value = response.data;
    await groupDataByRoom();
  } catch (error) {
    console.error("Error fetching sensor data:", error);
  }
};

const fetchRoomSettings = async (roomName) => {
  try {
    const response = await axios.get(
      `http://192.168.1.125:8000/settings/${roomName}`
    );
    return response.data;
  } catch (error) {
    console.error(`Error fetching settings for room ${roomName}:`, error);
    return null;
  }
};

const groupDataByRoom = async () => {
  const grouped = sensorData.value.reduce((acc, data) => {
    if (!acc[data.roomName]) {
      acc[data.roomName] = [];
    }
    acc[data.roomName].push({
      temp: parseFloat(data.temp),
      humidity: parseFloat(data.humidity),
      created_at: data.created_at ? new Date(data.created_at) : new Date(),
    });
    return acc;
  }, {});

  for (const roomName in grouped) {
    const settings = await fetchRoomSettings(roomName);
    grouped[roomName].settings = settings;
  }

  groupedData.value = grouped;
};

onMounted(() => {
  fetchSensorData();
});
</script>

<style scoped>
.room-overview {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 10px;
}
</style>
