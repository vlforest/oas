<template>
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ user.name }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ user.email }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <Switcher :modelValue="user.role === 'Verified'" @update:modelValue="newRole => $emit('toggle-role', user, newRole)" />
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <DangerButton type="button" @click="$emit('confirm-delete-user', user)" class="me-2">
                        <i class="material-icons align-middle me-1">delete</i>
                        Delete
                    </DangerButton>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { defineProps } from 'vue';
import Switcher from '@/Components/Switcher.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    users: Array
});
</script>
