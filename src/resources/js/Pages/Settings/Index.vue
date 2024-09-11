<script setup lang="ts">
import {Head, Link} from "@inertiajs/vue3";
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
let Fahrenheit

function openNewSettingsModal() {
    openNewSettings.value = true;
}

function convertFahrenheit($c) {
    Fahrenheit = ($c * 9/5) + 32
    return Fahrenheit
}

console.log(props.settings)
console.log(props.settings.celcius)

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
                            <h3 class="font-bold size-16 w-full">Oversigt over indstillinger</h3>
                            <div class="mt-4">
                                <GreenButton @click="openNewSettingsModal">+ Ny</GreenButton>
                            </div>
                            <table class="w-full mt-2">
                                <tr>
                                    <th>Room name</th>
                                    <th>Interval</th>
                                    <th>Format</th>
                                    <th>Max temp</th>
                                    <th>Min temp</th>
                                    <th>Start tid</th>
                                    <th>Slut tid</th>
                                    <th></th>
                                </tr>
                                <tr v-for="row in settings" :key="row.id" class="text-center mb-2 border-b pb-4 border-green-300">
                                    <td>{{ row.roomName }}</td>
                                    <td>{{ row.interval }} min</td>
                                    <td>{{ 'row.celcius'? 'Celcius' : 'Fahrenheit' }} </td>
                                    <td>{{ 'row.celcius'? row.maxTemp + ' C' : convertFahrenheit(row.maxTemp) + ' F' }}</td>
                                    <td>{{ row.minTemp }}</td>
                                    <td>{{ row.startHour }}</td>
                                    <td>{{ row.endHour }}</td>
                                    <td>
                                        <Link methods="get" :href="route('settings.edit', row)">
                                            <GreenButton >Rediger</GreenButton>
                                        </Link>
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
