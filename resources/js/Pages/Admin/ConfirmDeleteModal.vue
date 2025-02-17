<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this user?</p>
                <div class="mt-4 flex items-center justify-end">
                    <SecondaryButton type="button" @click="$emit('close')" class="me-2">
                        <i class="material-icons align-middle me-1">cancel</i>
                        Cancel
                    </SecondaryButton>
                    <DangerButton type="button" @click="$emit('confirm')">
                        <i class="material-icons align-middle me-1">delete</i>
                        Delete
                    </DangerButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    show: Boolean
});
</script>
