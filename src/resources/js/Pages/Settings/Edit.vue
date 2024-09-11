<script setup lang="ts">
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import GreenButton from "@/Components/GreenButton.vue";
import {Settings} from "@/Types";


const props = defineProps<{
    settings: Object,
}>()

const form = useForm({
    interval: props.settings?.interval,
    celcius: props.settings?.celcius,
    maxTemp: props.settings?.maxTemp,
    minTemp: props.settings?.minTemp,
    startHour: props.settings?.startHour,
    endHour: props.settings?.endHour,
})
console.log(props.settings.roomName)

function submit() {
    form.put(route('settings.update', props.settings.roomName))
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
                            <div class="w-full flex">
                                <div class="w-1/4"></div>
                                <h3 class="font-bold w-full size-16">Ændre indstillinger for lokale {{ props.settings.roomName }}</h3>
                            </div>
                            <div>
                                <form @submit.prevent="submit">
                                    <div class="mt-3 text-center sm:mt-5">

                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="interval" class="text-right w-1/4">Interval</InputLabel>
                                            <TextInput v-model="form.interval" class="w-1/2 ml-5" />
                                            <InputError :message="form.errors.interval" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="celcius" class="text-right w-1/4">Temperatur format</InputLabel>
                                            <input v-model.checkbox="form.celcius" type="checkbox" class="rounded-sm mx-5" />
                                            <InputLabel class="text-right">Celcius</InputLabel>
                                            <InputError :message="form.errors.celcius" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="maxTemp" class="text-right w-1/4">Max Temp</InputLabel>
                                            <TextInput v-model="form.maxTemp" class="w-1/2 ml-5" />
                                            <InputError :message="form.errors.maxTemp" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="minTemp" class="text-right w-1/4">Min Temp</InputLabel>
                                            <TextInput v-model="form.minTemp" class="w-1/2 ml-5" />
                                            <InputError :message="form.errors.minTemp" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="startHour" class="text-right w-1/4">Start Tid</InputLabel>
                                            <TextInput v-model="form.startHour" class="w-1/2 ml-5" placeholder="08:00" />
                                            <InputError :message="form.errors.startHour" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="endHour" class="text-right w-1/4">Slut Tid</InputLabel>
                                            <TextInput v-model="form.endHour" class="w-1/2 ml-5" placeholder="16:00"/>
                                            <InputError :message="form.errors.endHour" class="ml-2" />
                                        </div>
                                    </div>
                                    <div class="w-full flex mt-4">
                                        <div class="w-1/4"></div>
                                        <GreenButton type="submit" @click="submit">Gem indstillinger</GreenButton>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
