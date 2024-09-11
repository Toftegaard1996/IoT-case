<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {OfficeRooms} from "@/Types";
import GraphView from "@/Components/GraphView.vue";


const props = defineProps<{
    officeRoomToday: OfficeRooms[]
    rooms: OfficeRooms[]
}>()

</script>

<template>
    <Head title="Today's graph" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gårsdagens grafer</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Her kan du se graferne fra i går
                        <div v-for="row in rooms" :key="row.id">
                            <p>{{ row.roomName }}</p>
                            <GraphView />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
