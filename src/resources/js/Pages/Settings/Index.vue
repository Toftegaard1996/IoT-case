<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import type {OfficeRooms} from "@/Types";

const props = defineProps<{
    officeRoomToday: OfficeRooms[]
    rooms: OfficeRooms[]
}>()
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
                    <div class="p-6 text-gray-900">Her kan du se og ændre indstillinger for et gældende lokale
                        <div>
                            <p>Vælg lokale at ændre indstillinger for</p>
                            <Dropdown>
                                <DropdownLink v-for="row in rooms" :key="row.id">{{ row.roomName }}</DropdownLink>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
