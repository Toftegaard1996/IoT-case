<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import GraphView from "@/Components/GraphView.vue";
// import { OfficeRooms } from "@/Types";

const sensorData = ref([]);
const groupedData = ref({});

// const props = defineProps<{
//   officeRoomToday: OfficeRooms[];
//   rooms: OfficeRooms[];
// }>();

const fetchSensorData = async () => {
  try {
    const response = await axios.get("http://192.168.1.125:8000/update-sensor");
    console.log("API Response:", response.data); // Debugging log
    sensorData.value = response.data;
    groupDataByRoom();
  } catch (error) {
    console.error("Error fetching sensor data:", error);
  }
  location.reload();
};

const groupDataByRoom = () => {
  groupedData.value = sensorData.value.reduce((acc, data) => {
    if (!acc[data.roomName]) {
      acc[data.roomName] = [];
    }
    // Ensure data contains `temp` and `created_at` or adjust if different fields are used
    acc[data.roomName].push({
      temp: parseFloat(data.temp),
      created_at: data.created_at ? new Date(data.created_at) : new Date(),
    });
    return acc;
  }, {});
};

onMounted(() => {
  fetchSensorData();
});
</script>

<template>
  <Head title="Today's graph" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dagens grafer
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            Here you can see today's graph for temperatures in the office

            <!-- Loop through each room in groupedData and display its graph -->
            <div v-for="(temps, roomName) in groupedData" :key="roomName">
              <p>{{ roomName }}</p>
              <!-- Pass room-specific data to the GraphView component -->
              <GraphView :roomName="roomName" :temperatureData="temps" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
