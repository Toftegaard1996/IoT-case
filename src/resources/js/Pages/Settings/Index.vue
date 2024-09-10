<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import type {OfficeRooms, Settings} from "@/Types";
import GreenButton from "@/Components/GreenButton.vue";
import FormNewSettings from "@/Components/FormNewSettings.vue";
import {ref} from "vue";


const props = defineProps<{
    officeRoomToday: OfficeRooms[]
    rooms: OfficeRooms[]
    settings: Settings[]
}>()

const openNewSettings = ref<boolean>(false)

function openNewSettingsModal() {
    openNewSettings.value = true;
}
</script>

<template>
    <Head title="Today's graph" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900"><!--Her kan du se og ændre indstillinger for et gældende lokale -->
                        <div>
                            <p>Oversigt over indstillinger</p>
                            <div class="mt-4">
                                <GreenButton @click="openNewSettingsModal">+ Ny</GreenButton>
                            </div>
                            <table class="w-full mt-2">
                                <tr>
                                    <th>Room name</th>
                                    <th>Interval</th>
                                    <th>Max temp</th>
                                    <th>Min temp</th>
                                    <th>Start tid</th>
                                    <th>Slut tid</th>
                                    <th></th>
                                </tr>
                                <tr v-for="row in settings" :key="row.id" class="text-center">
                                    <td>{{ row.roomName }}</td>
                                    <td>{{ row.interval }} min</td>
                                    <td>{{ row.maxTemp }}</td>
                                    <td>{{ row.minTemp }}</td>
                                    <td>{{ row.startHour }}</td>
                                    <td>{{ row.endHour }}</td>
                                    <td>
                                        <GreenButton method="get" :href="route('settings.edit', row)">Rediger</GreenButton>
                                    </td>

                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <FormNewSettings :open="openNewSettings" @close="openNewSettings = false" />
        </div>
    </AuthenticatedLayout>
</template>
