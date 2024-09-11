<script setup lang="ts">
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {useForm} from "@inertiajs/vue3";
import GreenButton from "@/Components/GreenButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps<{
    open: Boolean,
}>()

defineEmits<{
    close: [state: Boolean]
}>()

const form = useForm({
    roomName : '',
    interval: '',
    celcius: true,
    maxTemp: '',
    minTemp: '',
    startHour: '',
    endHour: ''
})

function submit(){
    form.post(route('settings.store'));
}
</script>

<template>
    <TransitionRoot as="template" :show="props.open">
        <Dialog class="relative z-10" @close="$emit('close', true)">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <form @submit.prevent="submit">
                                <div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Opret indstillinger til et nyt lokale</DialogTitle>


                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="roomName" class="text-right w-1/4">Rum navn</InputLabel>
                                            <TextInput v-model="form.roomName" class="w-1/2 ml-5" />
                                            <InputError :message="form.errors.roomName" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="interval" class="text-right w-1/4">Interval</InputLabel>
                                            <TextInput v-model="form.interval" class="w-1/2 ml-5" />
                                            <InputError :message="form.errors.interval" class="ml-2" />
                                        </div>
                                        <div class="flex flex-row px-2 py-2 items-center w-full pb-4 mt-2">
                                            <InputLabel for="celcius" class="text-right w-1/4">Temperatur format</InputLabel>
                                            <input v-model.checkbox="form.celcius" type="checkbox" class="rounded-sm mx-5" />
                                            <InputLabel for="country" class="text-right">Celcius</InputLabel>
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
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 md:flex">
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0" @close="$emit('close', true)" ref="cancelButtonRef">Cancel</button>
                                    <GreenButton type="submit" class="inline-flex w-full justify-center">Gem</GreenButton>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

