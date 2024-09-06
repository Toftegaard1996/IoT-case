<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {OfficeRooms} from "@/Types";


const props = defineProps<{
    officeRoomToday: OfficeRooms[]
    rooms: OfficeRooms[]
}>()
console.log(props.officeRoomToday);
</script>

<template>
    <Head title="Today's graph" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Here you can see today's graph for temperatures in the office
                        <div v-for="row in rooms" :key="row.id">
                            <p>{{ row.roomName }}</p>
                            <p>{{ row.temp }}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
