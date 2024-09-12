<!-- resources/js/components/TemperatureGraph.vue -->
<template>
  <div>
    <h2>Room Temperature Graphs</h2>
    <div v-for="(data, room) in groupedData" :key="room">
      <graph-view :roomName="room" :temperatureData="data"></graph-view>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import GraphView from "./GraphView.vue";

export default {
  components: {
    GraphView,
  },
  data() {
    return {
      sensorData: [],
      groupedData: {},
    };
  },
  mounted() {
    this.fetchSensorData();
  },
  methods: {
    fetchSensorData() {
      axios.get("http://192.168.1.125:8000/update-sensor").then((response) => {
        this.sensorData = response.data;
        this.groupDataByRoom();
      });
    },
    groupDataByRoom() {
      this.groupedData = this.sensorData.reduce((acc, data) => {
        if (!acc[data.roomName]) {
          acc[data.roomName] = [];
        }
        acc[data.roomName].push(data.temp);
        return acc;
      }, {});
    },
  },
};
</script>
